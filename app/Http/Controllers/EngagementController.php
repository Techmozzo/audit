<?php

namespace App\Http\Controllers;

use App\Http\Requests\EngagementRequest;
use App\Models\Engagement;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EngagementController extends Controller
{

    public function index()
    {
        $engagements = Engagement::where('company_id', auth()->user()->company_id)->get();
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
        $engagement = auth()->user()->company->engagement()->create($request->all());
        return response()->success(Response::HTTP_CREATED, 'Engagement created successfully', ['engagement' => $engagement]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($engagementId)
    {
        $response = response()->error(Response::HTTP_NOT_FOUND, 'Engagement does not exist.');
        $engagement = Engagement::where([['id', $engagementId], ['company_id', auth()->user()->company_id]])->first();
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
        $response = response()->error(Response::HTTP_NOT_FOUND, 'Client does not exist.');
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
