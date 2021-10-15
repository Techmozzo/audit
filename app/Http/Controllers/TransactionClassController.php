<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionClassRequest;
use App\Models\TransactionClass;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionClassController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionClassRequest $request)
    {
        $transactionClass = TransactionClass::create($request->all());
        return response()->success(Response::HTTP_CREATED, 'Transaction class created successfully', ['transactionClass' => $transactionClass]);
    }

    public function update(Request $request){

    }
}
