<?php

namespace App\Actions;

use App\Models\Execution;

class CreateExecution{
    public function __invoke($request, $engagmentId)
    {
        return Execution::updateOrCreate(['engagement_id' => $engagmentId, 'company_id' => auth()->user()->company_id], $request->all());
    }
}
