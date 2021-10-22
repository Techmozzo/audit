<?php

namespace App\Http\Controllers;

use App\Actions\CreateConclusion;
use App\Http\Requests\ConclusionRequest;
use App\Models\Conclusion;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConclusionController extends Controller
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
    public function store(ConclusionRequest $request,$engagmentId, CreateConclusion $createConclusion)
    {
        $conclusion = $createConclusion($request, $engagmentId);
        return response()->success(Response::HTTP_CREATED, 'Conclusion Created Successfully', ['conclusion' => $conclusion]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conclusion  $conclusion
     * @return \Illuminate\Http\Response
     */
    public function show(Conclusion $conclusion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conclusion  $conclusion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conclusion $conclusion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conclusion  $conclusion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conclusion $conclusion)
    {
        //
    }
}
