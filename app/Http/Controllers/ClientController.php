<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::where('company_id', auth()->user()->company_id)->get();
        return response()->success(Response::HTTP_OK, 'Request successful', ['clients' => $clients]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\ClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $client = Client::create($request->all() + ['company_id' => auth()->user()->company_id]);
        return response()->success(Response::HTTP_CREATED, 'Client created successfully', ['client' => $client]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($clientId)
    {
        $response = response()->error(Response::HTTP_NOT_FOUND, 'Client does not exist.');
        $client = Client::where([['id', $clientId], ['company_id', auth()->user()->company_id]])->first();
        if($client !== null) $response = response()->success(Response::HTTP_OK, 'Request successfully', ['client' => $client]);
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $clientId)
    {
        $response = response()->error(Response::HTTP_NOT_FOUND, 'Client does not exist.');
        $client = Client::where([['id', $clientId], ['company_id', auth()->user()->company_id]])->first();
        if($client !== null){
            $client->update($request->all());
            $response = response()->success(Response::HTTP_OK, 'Request successfully', ['client' => $client]);
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
