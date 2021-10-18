<?php

namespace App\Http\Controllers;

use App\Actions\CreateMateriality;
use App\Http\Requests\MaterialityRequest;
use App\Models\Materiality;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaterialityController extends Controller
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
    public function store(MaterialityRequest $request, $planningId, CreateMateriality $createMateriality)
    {
        $data = $createMateriality->execute($request, $planningId);
        return response()->success(Response::HTTP_CREATED, 'Materiality Created Successfully', [$data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Materiality  $materiality
     * @return \Illuminate\Http\Response
     */
    public function show(Materiality $materiality)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Materiality  $materiality
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Materiality $materiality)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Materiality  $materiality
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materiality $materiality)
    {
        //
    }
}
