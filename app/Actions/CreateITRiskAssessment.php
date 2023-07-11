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
                if($request->risk_assessment_status){
                    $planning->iTRiskAssessment()->create(
                        ['company_id' => $planning->company_id, 'status' => true, 'name' => $assessment['name'], 'function' => $assessment['function'], 'review_performed' => $assessment['review_performed']]
                    );
                }else{
                    $planning->iTRiskAssessment()->create(
                        ['company_id' => $planning->company_id]
                    );
                }

            }
        });
        return ITRiskAssessment::where('planning_id', $planning->id)->get(['id', 'planning_id', 'company_id', 'status', 'name', 'function', 'review_performed']);
    }
}
