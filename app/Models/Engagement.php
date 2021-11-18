<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Engagement extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'client_id', 'name', 'year', 'first_time', 'audit_id', 'engagement_letter', 'accounting_standard', 'auditing_standard', 'external_expert', 'appointment_letter', 'contacted_previous_auditor', 'previous_auditor_response',  'previous_audit_opinion','previous_audit_review', 'other_audit_opinion', 'previous_year_management_letter', 'previous_year_asf', 'status'];


    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function note(){
        return $this->hasMany(EngagementNote::class);
    }

    public function planning(){
        return $this->hasOne(Planning::class)->select('id', 'company_id', 'engagement_id', 'trial_balance','test_details','control_testing','journal_entries','material_misstatement','combine_risk_assessment','planning_analytics');
    }

    public function execution(){
        return $this->hasMany(Execution::class)->select('id', 'engagement_id','company_id','contract_agreement_review','legal_counsel_review','contingent_liability_review','party_transaction_review','expert_work_review','other_estimate_review');
    }

    public function conclusion(){
        return $this->hasMany(Conclusion::class)->select('id', 'engagement_id', 'company_id','overall_analytical_review','going_concern_procedures','subsequent_procedures','management_representation_letter',
        'management_letter','audit_summary_misstatement','audit_report','audited_financial_statement','other_financial_info','status');
    }

    public function teamMembers(){
        return $this->hasMany(EngagementTeamMembers::class)->select('id','user_id', 'engagement_team_role_id', 'company_id', 'engagement_id');
    }
}
