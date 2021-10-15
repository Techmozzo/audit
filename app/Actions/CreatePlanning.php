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
        $planning = Planning::create([
            'trial_balance' => $request->trial_balance,
            'engagement_id' => $engagmentId,
            'company_id' => $companyId
        ]);
        $this->createTransactionClass($request, $planning->id, $companyId);
        $this->createMaterialityBenchmark($request, $planning->id, $companyId);
        return Planning::with('transactionClass:id,planning_id,company_id,name,process_flow_document','materialityBenchmark:id,planning_id,company_id,amount,reason')->where('id', $planning->id)->select('id', 'company_id', 'engagement_id', 'trial_balance')->first();
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

    private function createMaterialityBenchmark($request, $planningId, $companyId)
    {
        MaterialityBenchmark::create([
            'amount' => $request->materiality_amount,
            'reason' => $request->materiality_reason,
            'planning_id' => $planningId,
            'company_id' => $companyId
        ]);
    }
}
