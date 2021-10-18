<?php

namespace App\Http\Controllers;

use App\Actions\CreateITRiskAssessment;
use App\Actions\CreatePlanning;
use App\Actions\FindPlanning;
use App\Http\Requests\PlanningRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlanningController extends Controller
{
    protected $findPlanning;

    public function __construct(FindPlanning $findPlanning){
        $this->findPlanning = $findPlanning;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanningRequest $request, $engagmentId, CreatePlanning $createPlanning)
    {
        $planning = $createPlanning->create($request, $engagmentId);
        return response()->success(Response::HTTP_CREATED, 'Planning Created Successfully', ['planning' => $planning]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $planningId, CreateITRiskAssessment $createITRiskAssessment){
        $planning = $this->findPlanning->__invoke($planningId);
        if($request->risk_assessment_name){
            $createITRiskAssessment($request, $planning);
        }
        $planning->update($request->all());
        return response()->success(Response::HTTP_ACCEPTED, 'Planning Updated Successfully');
    }
}
