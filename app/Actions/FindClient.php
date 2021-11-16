<?php

namespace App\Actions;

use App\Models\Client;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class FindClient{
    public function __invoke($clientId){
        $client = Client::where('id', $clientId)->when(auth()->check(), function($query){
            return $query->where('company_id', auth()->user()->company_id);
        })->first();
        if($client == null){
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Client does not exist'));
        }else{
            return $client;
        }
    }
}
