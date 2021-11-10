<?php

namespace App\Actions;

use App\Models\Message;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class FindMessage{
    public function __invoke($messageId){
        $message = Message::with('documents:id,message_id,url')->where([['id', $messageId], ['company_id', auth()->user()->company_id]])->first();
        if($message == null){
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Message does not exist'));
        }else{
            return $message;
        }
    }
}
