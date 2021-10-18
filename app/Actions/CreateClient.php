<?php

namespace App\Actions;

use App\Models\Client;

class CreateClient
{
    public function store($request)
    {
        $client = Client::create([
            'company_id' => auth()->user()->company_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'registered_address' => $request->registered_address,
            'is_public_entity' => $request->is_public_entity,
            'nature_of_business' => $request->nature_of_business,
            'doubts' => $request->doubts
        ]);
        $this->storeDirector($client, $request);
        $this->storeSubsidiary($client, $request);
        return $client;
    }

    private function storeDirector($client, $request)
    {
        foreach ($request->director_name as $key => $name) {
            $client->director()->create([
                'company_id' => $client->company_id,
                'client_id' => $client->client_id,
                'name' => $name,
                'units_held' => $request->director_units_held[$key],
                'designation' => $request->director_designation[$key]
            ]);
        }
    }

    private function storeSubsidiary($client, $request)
    {
        foreach ($request->director_name as $key => $name) {
            $client->subsidiary()->create([
                'company_id' => $client->company_id,
                'client_id' => $client->client_id,
                'name' => $name,
                'percentage_holding' => $request->subsidiary_percentage_holding[$key],
                'nature' => $request->subsidiary_nature[$key],
                'nature_of_business' => $request->subsidiary_nature_of_business[$key]
            ]);
        }
    }
}