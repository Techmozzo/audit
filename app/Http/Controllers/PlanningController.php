<?php

namespace App\Http\Controllers;

use App\Actions\CreatePlanning;
use App\Http\Requests\PlanningRequest;
use App\Models\Planning;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlanningController extends Controller
{
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


    public function update(Request $request, $planningId){
        // $planning = Planning::
    }

}
