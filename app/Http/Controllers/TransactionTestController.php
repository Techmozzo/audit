<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionTestRequest;
use App\Models\Assertion;
use App\Models\TestProcedure;
use App\Models\TransactionTest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionTestRequest $request, $classId)
    {
        $companyId = auth()->user()->company_id;
        $test = TransactionTest::create(['name' => $request->test_name, 'company_id' => $companyId, 'transaction_class_id' => $classId ]);
        foreach($request->test_procedure as $key => $procedure){
            TestProcedure::create(['description' => $procedure, 'company_id' => $companyId, 'transaction_test_id' => $test->id]);
        }
        Assertion::create($request->all() + ['company_id' => $companyId, 'transaction_test_id' => $test->id]);
        $test =  TransactionTest::with('procedure:id,transaction_test_id,description', 'assertion:id,transaction_test_id,completeness,existence,accuracy,valuation,obligation_right,disclosure_presentation')->where('id', $test->id)->get();
        return response()->success(Response::HTTP_CREATED, 'Test created successfully', ['test' => $test]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransactionTest  $transactionTest
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionTest $transactionTest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransactionTest  $transactionTest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionTest $transactionTest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionTest  $transactionTest
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionTest $transactionTest)
    {
        //
    }
}
