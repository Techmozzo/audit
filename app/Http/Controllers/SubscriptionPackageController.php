<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubscriptionPackageResource;
use App\Models\SubscriptionPackage;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionPackageController extends Controller
{

    public function __invoke(){
        return response()->success(Response::HTTP_OK, 'Request successful', ['packages' => SubscriptionPackageResource::collection(SubscriptionPackage::all())]);
    }
}
