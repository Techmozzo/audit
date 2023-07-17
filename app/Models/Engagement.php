<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Engagement extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'client_id', 'name', 'year', 'first_time', 'audit_id', 'engagement_letter', 'accounting_standard', 'auditing_standard', 'sufficient_staff_power', 'partner_skill', 'external_expert', 'appointment_letter', 'contacted_previous_auditor', 'previous_auditor_response',  'previous_audit_opinion','previous_audit_review', 'other_audit_opinion', 'previous_year_management_letter', 'previous_year_asf', 'status_id'];

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
        return $this->hasOne(Planning::class)->with(['transactionClass.procedures.assertions' => function($query){
            $query->join('assertions as A', 'A.id', '=', 'procedure_assertions.assertion_id')->addSelect('A.id', 'A.name', 'procedure_assertions.value');
        }]);
    }

    public function execution(){
        return $this->hasOne(Execution::class);
    }

    public function conclusion(){
        return $this->hasOne(Conclusion::class);
    }

    public function teamMembers(){
        return $this->hasMany(EngagementTeamMembers::class);
    }

    public function status(){
        return $this->belongsTo(EngagementStage::class, 'status_id');
    }
}
