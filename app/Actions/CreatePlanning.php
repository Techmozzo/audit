<?php

namespace App\Actions;

use App\Models\Planning;
use App\Models\TransactionClass;

class CreatePlanning
{
    public function create($request, $engagmentId)
    {
        $companyId = auth()->user()->company_id;
        $planning = Planning::updateOrCreate(
            ['engagement_id' => $engagmentId, 'company_id' => $companyId],
            ['trial_balance' => $request->trial_balance]
        );
        $this->createTransactionClass($request, $planning, $companyId);
        return Planning::with('transactionClass:id,planning_id,company_id,name,process_flow_document')->where('id', $planning->id)->select('id', 'company_id', 'engagement_id', 'trial_balance')->first();
    }

    private function createTransactionClass($request, $planning, $companyId)
    {
        $planning->transactionClass()->delete();
        foreach ($request->classes as $class) {
            TransactionClass::updateOrCreate([
                'planning_id' => $planning->id,
                'company_id' => $companyId,
                'name' => $class['name'],
                'process_flow_document' => $class['process_flow_document']
            ]);
        }
    }
}
