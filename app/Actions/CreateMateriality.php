<?php

namespace App\Actions;

use App\Models\Materiality;

class CreateMateriality
{
    public function execute($request, $planningId)
    {
        $companyId = auth()->user()->company_id;
        $this->createOverallMateriality($request, $companyId, $planningId);
        $this->createPerformanceMateriality($request, $companyId, $planningId);
        $this->createPostingThreshold($request, $companyId, $planningId);
        return Materiality::with('level:id,name,type')->where('planning_id', $planningId)->get(['id', 'materiality_level_id', 'planning_id', 'company_id', 'limit', 'amount', 'reason']);
    }

    private function createOverallMateriality($request, $companyId, $planningId)
    {
        Materiality::updateOrCreate(
            ['materiality_level_id' => $request->overall_materiality_level_id, 'planning_id' => $planningId, 'company_id' => $companyId],
            ['limit' => $request->overall_materiality_limit, 'amount' => $request->overall_materiality_amount, 'reason' => $request->overall_materiality_reason]
        );
    }

    private function createPerformanceMateriality($request, $companyId, $planningId)
    {
        Materiality::updateOrCreate(
            ['materiality_level_id' => $request->performance_materiality_level_id, 'planning_id' => $planningId, 'company_id' => $companyId],
            ['limit' => $request->performance_materiality_limit, 'amount' => $request->performance_materiality_amount, 'reason' => $request->performance_materiality_reason]
        );
    }

    private function createPostingThreshold($request, $companyId, $planningId)
    {
        Materiality::updateOrCreate(
            ['materiality_level_id' => $request->threshold_level_id, 'planning_id' => $planningId, 'company_id' => $companyId],
            ['limit' => $request->threshold_limit, 'amount' => $request->threshold_amount, 'reason' => $request->threshold_reason]
        );
    }
}
