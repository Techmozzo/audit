<?php

namespace App\Http\Controllers;

use App\Models\Assertion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssertionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assertions = Assertion::select('id','name')->get();
        return response()->success(Response::HTTP_OK, 'Request Successful', ['assertions' => $assertions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assertion  $assertion
     * @return \Illuminate\Http\Response
     */
    public function show(Assertion $assertion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assertion  $assertion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assertion $assertion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assertion  $assertion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assertion $assertion)
    {
        //
    }
}
