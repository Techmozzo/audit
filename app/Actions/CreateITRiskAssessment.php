<?php

namespace App\Actions;

use App\Models\ITRiskAssessment;

class CreateITRiskAssessment
{
    public function __invoke($request, $planning)
    {
        $planning->iTRiskAssessment()->delete();
        foreach ($request->risk_assessment_name as $key => $name) {
            $planning->iTRiskAssessment()->create(
                ['company_id' => $planning->company_id, 'name' => $name, 'function' => $request->risk_assessment_function[$key], 'review_performed' => $request->risk_assessment_review_performed[$key]]
            );
        }
        return ITRiskAssessment::where('planning_id', $planning->id)->get(['id', 'planning_id', 'company_id', 'name', 'function', 'review_performed']);
    }
}
