<?php

namespace App\Http\Controllers;

use App\Actions\CreateExecution;
use App\Http\Requests\ExecutionRequest;
use App\Models\Execution;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExecutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExecutionRequest $request, $engagmentId, CreateExecution $createExecution)
    {
        $execution = $createExecution($request, $engagmentId);
        return response()->success(Response::HTTP_CREATED, 'Execution Created Successfully', ['execution' => $execution]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Execution  $execution
     * @return \Illuminate\Http\Response
     */
    public function show(Execution $execution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Execution  $execution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Execution $execution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Execution  $execution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Execution $execution)
    {
        //
    }
}
