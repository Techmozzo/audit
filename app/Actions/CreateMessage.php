<?php

namespace App\Actions;

use App\Models\Message;

class CreateMessage{
    public function __invoke($data, $clientId)
    {
        $message = Message::create([
            'company_id' => $data['company_id'],
            'client_id' => $clientId,
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'message' => $data['message'],
            'sender' => 'company'
        ]);

        if($data['documents'] !== null){
            foreach($data['documents'] as $document){
                $message->documents()->create([
                    'company_id' => $data['company_id'],
                    'client_id' => $clientId,
                    'url' => $document
                ]);
            }
        }

        return $message;
    }
}
