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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConclusionRequest $request, $engagmentId)
    {
        $conclusion = Conclusion::updateOrCreate(['engagement_id' => $engagmentId, 'company_id' => auth()->user()->company_id], $request->all());
        return response()->success(Response::HTTP_CREATED, 'Conclusion Created Successfully', ['conclusion' => $conclusion]);
    }
}
