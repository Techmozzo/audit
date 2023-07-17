<?php

namespace App\Http\Controllers;

use App\Factories\UploadFileFactory;
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
        $file_name = UploadFileFactory::getStore(env('FILE_STORE', 'local'))->upload($request->file('trial_balance'));
        if(!$file_name){
            return response()->error(Response::HTTP_BAD_REQUEST, 'Upload Failed');
        }
        return response()->success(Response::HTTP_OK, 'Request Successful', ['classes' => $classes, 'url' => $file_name, 'name' => $request->file('trial_balance')->getClientOriginalName()]);
    }
}
