<?php

namespace App\Actions;

use App\Models\Client;
use App\Models\Engagement;
use App\Models\Message;
use App\Models\Planning;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class Finder{

    public static function client($clientId){
        $client = Client::with('company','directors','groups')->where('id', $clientId)->when(auth()->check(), function($query){
            return $query->where('company_id', auth()->user()->company_id);
        })->select('id', 'company_id', 'name', 'email', 'phone', 'address', 'registered_address', 'is_public_entity', 'nature_of_business', 'status')->first();
        if($client == null){
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Client does not exist'));
        }else{
            return $client;
        }
    }

    public static function message($messageId){
        $message = Message::with('documents:id,message_id,url')->where([['id', $messageId], ['company_id', auth()->user()->company_id]])->first();
        if($message == null){
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Message does not exist'));
        }else{
            return $message;
        }
    }

    public static function planning($planningId){
        $planning = Planning::where([['id', $planningId], ['company_id', auth()->user()->company_id]])->first();
        if($planning == null){
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Planning does not exist'));
        }else{
            return $planning;
        }
    }


    public static function engagement($engagementId){
        $engagement = Engagement::with(['client', 'planning', 'execution', 'conclusion', 'status', 'teamMembers' => function($query){
            $query->with('role','user');
        }])->where([['id', $engagementId], ['company_id', auth()->user()->company_id]])->first();
        if($engagement == null){
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Engagement does not exist'));
        }else{
            return $engagement;
        }
    }


}
