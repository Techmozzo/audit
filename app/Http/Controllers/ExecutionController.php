<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssertionRequest;
use App\Http\Requests\ExecutionRequest;
use App\Models\Execution;
use App\Models\Procedure;
use Symfony\Component\HttpFoundation\Response;

class ExecutionController extends Controller
{
    public function majorProcedure(AssertionRequest $request)
    {
        foreach ($request->procedures as $procedure) {
            $procedureInstance = Procedure::with(['procedureAssertions' => function ($query) use ($procedure) {
                $query->whereIn('procedure_assertions.id', $procedure['assertions']);
            }])->where('procedures.id', $procedure['id'])->first();
            if (isset($procedure['other_info'])) {
                // $procedureInstance->update(['other_info' => $procedure['other_info']]);
            }
            $procedureInstance->procedureAssertions->map(function($assertion){
                $assertion->update(['value' => 1]);
            });
        }
        return response()->success(Response::HTTP_CREATED, 'Assertions Updated Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function minorProcedure(ExecutionRequest $request, $engagmentId)
    {
        $execution = Execution::updateOrCreate(['engagement_id' => $engagmentId, 'company_id' => auth()->user()->company_id], $request->all());
        return response()->success(Response::HTTP_CREATED, 'Execution Created Successfully', ['execution' => $execution]);
    }
}
