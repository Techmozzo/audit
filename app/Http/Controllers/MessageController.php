<?php

namespace App\Http\Controllers;

use App\Actions\CreateMessage;
use App\Actions\FindClient;
use App\Actions\FindMessage;
use App\Http\Requests\MessageRequest;
use App\Jobs\MessageAdminJob;
use App\Jobs\MessageJob;
use App\Models\Message;
use App\Traits\HashId;
use Carbon\Carbon;
use League\CommonMark\Node\Block\Document;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    use HashId;

    public function sendMessageByCompany(MessageRequest $request, $clientId, CreateMessage $createMessage, FindClient $findClient)
    {
        $user = auth()->user();
        $client = $findClient($clientId);
        $data = ['company_id' => $user->company_id, 'user_id' => $user->id, 'title' => $request->title, 'message' => $request->message, 'sender' => 'company', 'documents' => $request->documents ?? null];
        $message = $createMessage($data, $clientId);
        MessageJob::dispatch($client, $this->encrypt($clientId))->onQueue('audit_queue');
        return response()->success(Response::HTTP_OK, 'Request Successful', ['message' => $message]);
    }

    public function sendMessageByClient(MessageRequest $request, $clientToken, CreateMessage $createMessage, FindClient $findClient)
    {
        $token = $this->decrypt($clientToken);
        $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invalid Token');
        if (isset($token['data_id'])) {
            $client = $findClient($token['data_id']);
            $data = ['company_id' => $client->company_id, 'user_id' => null, 'title' => $request->title, 'message' => $request->message, 'sender' => 'client', 'documents' => $request->documents ?? null];
            $message = $createMessage($data, $client->id);
            MessageAdminJob::dispatch($client, 'admin@techmozzo.com')->onQueue('audit_queue');
            $response = response()->success(Response::HTTP_OK, 'Request Successful', ['message' => $message]);
        }
        return $response;
    }

    public function allMessagesByCompany($clientId, FindClient $findClient)
    {
        $client = $findClient($clientId);
        $messages = Message::with('documents:id,message_id,url')->where([['client_id', $client->id], ['company_id', auth()->user()->company_id]])->get();
        return response()->success(Response::HTTP_OK, 'Request Successful', ['messages' => $messages]);
    }

    public function allMessagesByClient($clientToken, FindClient $findClient)
    {
        $token = $this->decrypt($clientToken);
        $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invalid Token');
        if (isset($token['data_id'])) {
            $client = $findClient($token['data_id']);
            $messages = Message::with('documents:id,message_id,url')->where([['client_id', $client->id], ['company_id', $client->company_id]])->get();
            $response = response()->success(Response::HTTP_OK, 'Request Successful', ['messages' => $messages]);
        }
        return $response;
    }

    public function getMessage($id, FindMessage $findMessage)
    {
        $message = $findMessage->__invoke($id);
        return response()->success(Response::HTTP_OK, 'Request Successful', ['message' => $message]);
    }

    public function clientMessagingLink($clientId)
    {
        $link = 'http://localhost:8000/audit-messages/'.$this->encrypt($clientId)['data_token'];
        return response()->success(Response::HTTP_OK, 'Request Successful', ['link' => $link]);
    }
}
