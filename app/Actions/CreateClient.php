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
        ]);

        if(isset($request->directors)) $this->storeDirector($client, $request);
        if(isset($request->groups)) $this->storeGroup($client, $request);
        return $client;
    }

    private function storeDirector($client, $request)
    {
        foreach ($request->directors as $director) {
            $client->directors()->create([
                'company_id' => $client->company_id,
                'client_id' => $client->client_id,
                'name' => $director['name'],
                'units_held' => $director['units_held'] ?? null,
                'designation' => $director['designation']
            ]);
        }
    }

    private function storeGroup($client, $request)
    {
        foreach ($request->groups as $group) {
            $client->groups()->create([
                'company_id' => $client->company_id,
                'client_id' => $client->client_id,
                'name' => $group['name'],
                'percentage_holding' => $group['percentage_holding'],
                'industry' => $group['industry'],
                'type' => $group['type']
            ]);
        }
    }

}
