<?php

namespace App\Actions;

use App\Models\Planning;
use App\Models\Procedure;
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
        return Planning::with('transactionClass.procedures')->where('id', $planning->id)->select('id', 'company_id', 'engagement_id', 'trial_balance', 'stage')->first();
    }

    private function createTransactionClass($request, $planning, $companyId)
    {
        $planning->transactionClass()->delete();
        foreach ($request->classes as $class) {
            $classInstance = TransactionClass::updateOrCreate(
                [
                    'planning_id' => $planning->id,
                    'company_id' => $companyId,
                    'name' => $class['name']
                ],
                [
                    'process_flow_document' => $class['process_flow_document'],
                    'work_through' => $class['work_through']
                ]
            );

            $classInstance->procedures()->delete();
            $this->createProcedures($class['procedures'], $classInstance, $companyId);
        }
    }

    private function createProcedures($procedures, $class, $companyId){
        foreach($procedures as $procedure){
            $procedureInstance = Procedure::updateOrCreate(['company_id' => $companyId, 'transaction_class_id' => $class->id, 'name' => $procedure['name']], ['description' => $procedure['description']]);
            $procedureInstance->assertions()->sync($procedure['assertions']);
        }
    }
}
