<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Conclusion;
use App\Models\Engagement;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{

    protected $engagemetAttribute = ['id','company_id', 'client_id', 'name', 'year', 'first_time', 'audit_id', 'engagement_letter', 'accounting_standard', 'auditing_standard', 'external_expert', 'appointment_letter', 'contacted_previous_auditor', 'previous_auditor_response',  'previous_audit_opinion','previous_audit_review', 'other_audit_opinion', 'previous_year_management_letter', 'previous_year_asf', 'status'];

    public function admin()
    {
        $user = auth()->user();
        $engagementQuery = Engagement::with('client:id,name', 'status')->where('company_id', $user->company_id);
        $clientQuery = Client::where('company_id', $user->company_id);
        $conclusionQuery = Conclusion::where('company_id', $user->company_id);
        $engagementCount = $engagementQuery->count();
        $concludedEngagementCount = $conclusionQuery->where('status', 3)->count();
        $unreadNotifications = Notification::where('notifiable_id', $user->id)->whereNull('read_at')->select('data', 'type')->get();
        $unreadNotificationsCount = $unreadNotifications->count();

        $data = [
            'company' => $user->company,
            'client' => $clientQuery->get(),
            'engagements' => $engagementQuery->select($this->engagemetAttribute)->get(),
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
        $engagementQuery = DB::table('engagements as E')->select('E.*')
        ->join('clients as C', 'C.id', '=', 'E.client_id')
        ->join('engagement_stages as ES', 'ES.id', '=', 'E.status')
        ->join('engagement_team_members as ETM', 'ETM.engagement_id', '=', 'E.id');

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
