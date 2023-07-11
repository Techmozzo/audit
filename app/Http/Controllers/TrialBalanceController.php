<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrialBalanceUploadRequest;
use App\Imports\TrialBalanceImport;
use App\Models\TrialBalance;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class TrialBalanceController extends Controller
{
    public function upload(TrialBalanceUploadRequest $request)
    {
        Excel::import(new TrialBalanceImport(), $request->trial_balance);
        $classes = TrialBalance::distinct()->pluck('classes');
        DB::table('trial_balances')->truncate();
        return response()->success(Response::HTTP_OK, 'Request Successful', ['classes' => $classes]);
    }
}
