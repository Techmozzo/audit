<?php

namespace App\Http\Controllers;

use App\Actions\CreateMessage;
use App\Actions\FindMessage;
use App\Http\Requests\MessageRequest;
use App\Models\Client;
use App\Models\Message;
use App\Traits\HashId;
use League\CommonMark\Node\Block\Document;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    use HashId;

    public function sendMessageByCompany(MessageRequest $request, $clientId, CreateMessage $createMessage)
    {
        $user = auth()->user();
        $data = ['company_id' => $user->company_id, 'user_id' => $user->id, 'title' => $request->title, 'message' => $request->message, 'sender' => 'company', 'documents' => $request->documents ?? null];
        $message = $createMessage($data, $clientId);
        return response()->success(Response::HTTP_OK, 'Request Successful', ['message' => $message]);
    }

    public function sendMessageByClient(MessageRequest $request, $clientToken, CreateMessage $createMessage)
    {
        $token = $this->decrypt($clientToken);
        $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invalid Token');
        if (isset($token['data_id'])) {
            $client = Client::find($token['data_id']);
            $response = response()->error(Response::HTTP_NOT_FOUND, 'Client does not exist');
            if ($client !== null) {
                $data = ['company_id' => $client->company_id, 'user_id' => null, 'title' => $request->title, 'message' => $request->message, 'sender' => 'client', 'documents' => $request->documents ?? null];
                $message = $createMessage($data, $client->id);
                $response = response()->success(Response::HTTP_OK, 'Request Successful', ['message' => $message]);
            }
        }
        return $response;
    }

    public function allMessages($clientId)
    {
        $messages = Message::with('documents:id,message_id,url')->where([['client_id', $clientId], ['company_id', auth()->user()->company_id]])->get();
        return response()->success(Response::HTTP_OK, 'Request Successful', ['messages' => $messages]);
    }

    public function getMessage($id, FindMessage $findMessage)
    {
        $message = $findMessage->__invoke($id);
        return response()->success(Response::HTTP_OK, 'Request Successful', ['message' => $message]);
    }

    public function clientMessagingLink()
    {
    }
}
