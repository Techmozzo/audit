<?php

namespace App\Http\Controllers;

use App\Http\Requests\EngagementRequest;
use App\Models\Client;
use App\Models\Engagement;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EngagementController extends Controller
{

    protected $attribute = ['id','company_id', 'client_id', 'year', 'first_time', 'audit_id', 'engagement_letter', 'accounting_standard', 'auditing_standard', 'staff_power',
    'partner_skill', 'external_expert', 'members_dependence', 'appointment_letter', 'previous_auditor_opinion','previous_audit_review','previous_year_management_letter', 'previous_year_asf'];

    public function index()
    {
        $engagements = Engagement::where('company_id', auth()->user()->company_id)->select($this->attribute)->get();
        return response()->success(Response::HTTP_OK, 'Request successful', ['engagements' => $engagements]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EngagementRequest $request)
    {
        $response = response()->error(Response::HTTP_NOT_FOUND, 'Client does not exist.');
        $user = auth()->user();
        $client = Client::where([['id', $request->client_id], ['company_id', $user->company_id]])->first();
        if($client !== null){
            $audit_id = 'AT' . rand(100, 999) . rand(1000, 9999) . strtoupper(substr($client->name, 0, 2));
            $engagement = $client->engagement()->create($request->except('client_id')+['audit_id' => $audit_id, 'company_id' => $user->company_id]);
            $response = response()->success(Response::HTTP_CREATED, 'Engagement created successfully', ['client' => $client, 'engagement' => $engagement]);
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($engagementId)
    {
        $response = response()->error(Response::HTTP_NOT_FOUND, 'Engagement does not exist.');
        $engagement = Engagement::where([['id', $engagementId], ['company_id', auth()->user()->company_id]])->select($this->attribute)->first();
        if($engagement !== null) $response = response()->success(Response::HTTP_OK, 'Request successfully', ['engagement' => $engagement]);
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $engagementId)
    {
        $response = response()->error(Response::HTTP_NOT_FOUND, 'Engagement does not exist.');
        $engagement = Engagement::where([['id', $engagementId], ['company_id', auth()->user()->company_id]])->first();
        if($engagement !== null){
            $engagement->update($request->all());
            $response = response()->success(Response::HTTP_OK, 'Request successfully', ['engagement' => $engagement]);
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Engagement  $engagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Engagement $engagement)
    {
        //
    }
}
