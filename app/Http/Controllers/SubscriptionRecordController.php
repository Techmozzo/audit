<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;

class SubscriptionRecordController extends Controller
{
    public function __invoke()
    {
        $data = [
            'subscriptionRecord' => auth()->user()->company->subscriptionRecord()->with('package:id,name')
                ->get(['id', 'amount', 'duration', 'payment_reference', 'company_id', 'subscription_package_id'])
        ];
        return response()->success(Response::HTTP_OK, 'Request successful', $data);
    }
}
