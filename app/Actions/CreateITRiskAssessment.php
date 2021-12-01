<?php

namespace App\Actions;

use App\Models\ITRiskAssessment;
use Illuminate\Support\Facades\DB;

class CreateITRiskAssessment
{
    public function __invoke($request, $planning)
    {
        DB::transaction(function () use ($request, $planning) {
            $planning->iTRiskAssessment()->delete();
            foreach ($request->risk_assessments as $assessment) {
                $planning->iTRiskAssessment()->create(
                    ['company_id' => $planning->company_id, 'name' => $assessment['name'], 'function' => $assessment['function'], 'review_performed' => $assessment['review_performed']]
                );
            }
        });
        return ITRiskAssessment::where('planning_id', $planning->id)->get(['id', 'planning_id', 'company_id', 'name', 'function', 'review_performed']);
    }
}
