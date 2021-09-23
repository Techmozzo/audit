<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Http\Resources\SubscriptionRecordResource;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use App\Models\SubscriptionRecord;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    public function __invoke(SubscriptionRequest $request)
    {
        $subscriptionRecord = SubscriptionRecord::create($request->all() + ['company_id' => auth()->user()->company_id]);
        $subscription = Subscription::updateOrCreate(
            ['company_id' => auth()->user()->company_id],
            [
                'subscription_package_id' => $request->subscription_package_id,
                'is_active' => 1,
                'is_new' => 0,
                'expiration_date' => Carbon::now()->addDays($request->duration),
            ]
        );
        return response()->success(Response::HTTP_CREATED, 'Subscription successful', ['subscriptionRecord' => new SubscriptionRecordResource($subscriptionRecord), 'subscription' => new SubscriptionResource($subscription)]);
    }
}
