<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Conclusion;
use App\Models\Engagement;
use App\Models\Notification;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{

    public function admin()
    {
        $user = auth()->user();
        $engagementQuery = Engagement::with('client:id,name', 'status')->withCount('teamMembers')->where('company_id', $user->company_id);
        $clientQuery = Client::where('company_id', $user->company_id);
        $conclusionQuery = Conclusion::where('company_id', $user->company_id);
        $engagementCount = $engagementQuery->count();
        $concludedEngagementCount = $conclusionQuery->where('status', 3)->count();
        $unreadNotifications = Notification::where('notifiable_id', $user->id)->whereNull('read_at')->select('data', 'type')->get();
        $unreadNotificationsCount = $unreadNotifications->count();

        $data = [
            'company' => $user->company,
            'client' => $clientQuery->get(),
            'engagements' => $engagementQuery->get(),
            'clients_count' => $clientQuery->count(),
            'engagement_count' => $engagementCount,
            'concluded_engagement' => $concludedEngagementCount,
            'pending_engagement' => $engagementCount - $concludedEngagementCount,
            'unreadNotifications' => $unreadNotifications,
            'unreadNotificationsCount' => $unreadNotificationsCount
        ];
        return response()->success(Response::HTTP_OK, 'Request successful', $data);
    }

    public function staff()
    {
        $user = auth()->user();
        $engagementQuery = Engagement::with('client:id,name', 'status')->withCount('teamMembers')
        ->whereHas('teamMembers', function($query) use ($user){
            $query->where('user_id', $user->id);
        })
        ->where('company_id', $user->company_id);

        $clientQuery = Client::where('company_id', $user->company_id);
        $conclusionQuery = Conclusion::where('company_id', $user->company_id);
        $engagementCount = $engagementQuery->count();
        $concludedEngagementCount = $conclusionQuery->where('status', 3)->count();
        $unreadNotifications = Notification::where('notifiable_id', $user->id)->whereNull('read_at')->select('data', 'type')->get();
        $unreadNotificationsCount = $unreadNotifications->count();

        $data = [
            'company' => $user->company,
            'client' => $clientQuery->get(),
            'engagements' => $engagementQuery->get(),
            'clients_count' => $clientQuery->count(),
            'engagement_count' => $engagementCount,
            'concluded_engagement' => $concludedEngagementCount,
            'pending_engagement' => $engagementCount - $concludedEngagementCount,
            'unreadNotifications' => $unreadNotifications,
            'unreadNotificationsCount' => $unreadNotificationsCount
        ];
        return response()->success(Response::HTTP_OK, 'Request successful', $data);
    }




}
