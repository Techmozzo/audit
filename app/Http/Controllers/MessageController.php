<?php

namespace App\Http\Controllers;

use App\Actions\CreateMessage;
use App\Actions\Finder;
use App\Http\Requests\MessageRequest;
use App\Jobs\MessageAdminJob;
use App\Jobs\MessageJob;
use App\Models\Message;
use App\Traits\HashId;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    use HashId;

    public function sendMessageByCompany(MessageRequest $request, $clientId, CreateMessage $createMessage)
    {
        $user = auth()->user();
        $client = Finder::client($clientId);
        $data = ['company_id' => $user->company_id, 'user_id' => $user->id, 'title' => $request->title, 'message' => $request->message, 'sender' => 'company', 'documents' => $request->documents ?? null];
        $message = $createMessage($data, $clientId);
        // MessageJob::dispatch($client, $this->encrypt($clientId))->onQueue('audit_queue');
        MessageJob::dispatch($client, $this->encrypt($clientId));
        return response()->success(Response::HTTP_OK, 'Request Successful', ['message' => $message]);
    }

    public function sendMessageByClient(MessageRequest $request, $clientToken, CreateMessage $createMessage)
    {
        $token = $this->decrypt($clientToken);
        $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invalid Token');
        if (isset($token['data_id'])) {
            $client = Finder::client($token['data_id']);
            $data = ['company_id' => $client->company_id, 'user_id' => null, 'title' => $request->title, 'message' => $request->message, 'sender' => 'client', 'documents' => $request->documents ?? null];
            $message = $createMessage($data, $client->id);
            // MessageAdminJob::dispatch($client, 'admin@techmozzo.com')->onQueue('audit_queue');
            MessageAdminJob::dispatch($client, env('ADMIN_EMAIL'));
            $response = response()->success(Response::HTTP_OK, 'Request Successful', ['message' => $message]);
        }
        return $response;
    }

    public function allMessagesByCompany($clientId)
    {
        $client = Finder::client($clientId);
        $messages = Message::with('documents:id,message_id,url')->where([['client_id', $client->id], ['company_id', auth()->user()->company_id]])->get();
        return response()->success(Response::HTTP_OK, 'Request Successful', ['messages' => $messages]);
    }

    public function allMessagesByClient($clientToken)
    {
        $token = $this->decrypt($clientToken);
        $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invalid Token');
        if (isset($token['data_id'])) {
            $client = Finder::client($token['data_id']);
            $messages = Message::with('documents:id,message_id,url')->where([['client_id', $client->id], ['company_id', $client->company_id]])->get();
            $response = response()->success(Response::HTTP_OK, 'Request Successful', ['messages' => $messages]);
        }
        return $response;
    }

    public function getMessage($id)
    {
        $message = Finder::message($id);
        return response()->success(Response::HTTP_OK, 'Request Successful', ['message' => $message]);
    }

    public function clientMessagingLink($clientId)
    {
        $link = env('APP_URL')."/audit-messages/".$this->encrypt($clientId)['data_token'];
        return response()->success(Response::HTTP_OK, 'Request Successful', ['link' => $link]);
    }
}
