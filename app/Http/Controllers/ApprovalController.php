<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovalEnagagementStageRequest;
use App\Models\Engagement;

class ApprovalController extends Controller
{
    public function ApprovalEnagagementStage(int $engagement_id):object
    {
        $engagement = Engagement::find()
    }
}
