<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Conclusion;
use App\Models\Engagement;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{

    protected $engagemetAttribute = ['id','company_id', 'client_id', 'name', 'year', 'first_time', 'audit_id', 'engagement_letter', 'accounting_standard', 'auditing_standard', 'staff_power',
    'partner_skill', 'external_expert', 'members_dependence', 'appointment_letter', 'contacted_previous_auditor', 'previous_auditor_response',  'previous_audit_opinion','previous_audit_review', 'other_audit_opinion', 'previous_year_management_letter', 'previous_year_asf'];

    public function data()
    {
        $user = auth()->user();
        $engagementQuery = Engagement::where('company_id', $user->company_id);
        $clientQuery = Client::where('company_id', $user->company_id);
        $conclusionQuery = Conclusion::where('company_id', $user->company_id);
        $engagementCount = $engagementQuery->count();
        $concludedEngagementCount = $conclusionQuery->where('status', 1)->count();

        $data = [
            'company' => $user->company,
            'client' => $clientQuery->get(),
            'engagements' => $engagementQuery->select($this->engagemetAttribute)->get(),
            'clients_count' => $clientQuery->count(),
            'engagement_count' => $engagementCount,
            'concluded_engagement' => $concludedEngagementCount,
            'pending_engagement' => $engagementCount - $concludedEngagementCount
        ];

        return response()->success(Response::HTTP_OK, 'Request successful', $data);
    }

}
