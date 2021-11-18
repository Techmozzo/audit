<?php

namespace App\Http\Controllers;

use App\Actions\FindEngagement;
use App\Http\Requests\EngagementRequest;
use App\Models\Client;
use App\Models\Engagement;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EngagementController extends Controller
{

    protected $attribute = ['id','company_id', 'client_id', 'name', 'year', 'first_time', 'audit_id', 'engagement_letter', 'accounting_standard', 'auditing_standard',
     'external_expert', 'appointment_letter', 'contacted_previous_auditor', 'previous_auditor_response',  'previous_audit_opinion','previous_audit_review', 'other_audit_opinion', 'previous_year_management_letter', 'previous_year_asf', 'status'];

    protected $findEngagement;

    public function __construct(FindEngagement $findEngagement)
    {
        $this->findEngagement = $findEngagement;
    }

    public function index()
    {
        $engagements = Engagement::with('client')->where('company_id', auth()->user()->company_id)->select($this->attribute)->get();
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
        $engagement = $this->findEngagement->__invoke($engagementId);
        return response()->success(Response::HTTP_OK, 'Request successfully', ['engagement' => $engagement]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $engagementId)
    {
        $engagement = $this->findEngagement->__invoke($engagementId);
        $engagement->update($request->all());
        return response()->success(Response::HTTP_OK, 'Request successfully', ['engagement' => $engagement]);

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
