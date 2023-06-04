<?php

namespace App\Http\Controllers;

use App\Actions\StoreImageToCloud;
use App\Actions\UpdateCompany;
use App\Models\Company;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function profile(Company $company)
    {
        $subscriptionRecord = function($query){
            $query->with('package:id,name,description')->addSelect('amount','duration','payment_reference','subscription_package_id','company_id');
        };

        $subscription = function($query){
            $query->with('package:id,name,description')->addSelect('is_new','is_active','expiration_date','subscription_package_id','company_id');
        };

        $company = Company::where('id', auth()->user()->company_id)->with([
            'users:first_name,last_name,email,phone,designation,is_verified,company_id', 'subscription' => $subscription, 'subscriptionRecord' => $subscriptionRecord])->first();
        return response()->success(Response::HTTP_OK, 'Request Successful', ['company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoreImageToCloud $storeImageToCloud, UpdateCompany $updateCompany)
    {
        $response = response()->success(Response::HTTP_NOT_FOUND, 'Company does not exist.');
        $company = Company::where('id', auth()->user()->company_id)->first();
        if ($company !== null) {
            $updateCompany($request, $company, $storeImageToCloud);
            $response = response()->success(Response::HTTP_ACCEPTED, 'Update Successful', ['company' => $company]);
        }
        return $response;
    }
}
