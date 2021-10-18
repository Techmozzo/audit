<?php

namespace App\Actions;

use App\Models\MaterialityBenchmark;
use App\Models\Planning;
use App\Models\TransactionClass;

class CreatePlanning
{
    public function create($request, $engagmentId)
    {
        $companyId = auth()->user()->company_id;
        $planning = Planning::updateOrCreate(
            ['engagement_id' => $engagmentId,'company_id' => $companyId],
            ['trial_balance' => $request->trial_balance]
        );
        $this->createTransactionClass($request, $planning->id, $companyId);
        return Planning::with('transactionClass:id,planning_id,company_id,name,process_flow_document')->where('id', $planning->id)->select('id', 'company_id', 'engagement_id', 'trial_balance')->first();
    }

    private function createTransactionClass($request, $planningId, $companyId)
    {
        foreach ($request->class_name as $key => $transactionClass) {
            TransactionClass::create([
                'name' => $transactionClass,
                'process_flow_document' => $request['process_flow_document'][$key],
                'planning_id' => $planningId,
                'company_id' => $companyId
            ]);
        }
    }
}
