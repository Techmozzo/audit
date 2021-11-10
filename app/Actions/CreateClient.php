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
        if(isset($request->director_name)) $this->storeDirector($client, $request);
        if(isset($request->subsidiary_name)) $this->storeSubsidiary($client, $request);

        // if(isset($request->directors)) $this->storeDirector($client, $request);
        // if(isset($request->subsidiaries)) $this->storeSubsidiary($client, $request);
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
        foreach ($request->subsidiary_name as $key => $name) {
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



    // private function storeDirector($client, $request)
    // {
    //     foreach ($request->directors as $director) {
    //         $client->director()->create([
    //             'company_id' => $client->company_id,
    //             'client_id' => $client->client_id,
    //             'name' => $director['name'],
    //             'units_held' => $director['units_held'],
    //             'designation' => $director['designation']
    //         ]);
    //     }
    // }

    // private function storeSubsidiary($client, $request)
    // {
    //     foreach ($request->subsidiaries as $subsidiary) {
    //         $client->subsidiary()->create([
    //             'company_id' => $client->company_id,
    //             'client_id' => $client->client_id,
    //             'name' => $subsidiary['name'],
    //             'percentage_holding' => $subsidiary['percentage_holding'],
    //             'nature' => $subsidiary['nature'],
    //             'nature_of_business' => $subsidiary['nature_of_business']
    //         ]);
    //     }
    // }

}
