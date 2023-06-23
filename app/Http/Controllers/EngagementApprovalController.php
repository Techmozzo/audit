<?php

namespace App\Http\Controllers;

use App\Actions\Finder;
use Symfony\Component\HttpFoundation\Response;

class EngagementApprovalController extends Controller
{
    public function approve(int $engagement_id): object
    {
        $user = auth()->user();
        $engagement = Finder::engagement($engagement_id);
        dd($engagement->status);
        $stage = $engagement->status->name;
        dd($stage);
        if (strtolower($stage) == "planning") {
            $planning = Finder::planning($engagement->planning->id);
            $planning->update(['status' => 1]);
        } elseif (strtolower($stage) == "execution") {
            $execution = Finder::execution($engagement->execution->id);
            $execution->update(['status' => 1]);
        } elseif (strtolower($stage) == "conclusion") {
            $conclusion = Finder::conclusion($engagement->conclusion->id);
            $conclusion->update(['status' => 1]);
        }

        logAction([
            'name' => "Engagement Approval",
            'description' => "$user->name Approved the $stage stage of the $engagement->name Engagement",
            'causer_id' => $user->id,
        ]);

        return response()->success(Response::HTTP_OK, 'Request Successful', ['engagement' => $engagement]);
    }
}
