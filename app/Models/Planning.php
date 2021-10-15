<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;

    protected $guard = [];
    protected $fillable = ['company_id', 'engagement_id', 'trial_balance','test_details','control_testing','journal_entries','material_misstatement','combine_risk_assessment','planning_analytics'];

    public function transactionClass(){
        return $this->hasMany(TransactionClass::class);
    }

    public function materialityBenchmark(){
        return $this->hasMany(MaterialityBenchmark::class);
    }

    public function iTRiskAssessment(){
        return $this->hasMany(ITRiskAssessment::class, 'planning_id');
    }
}
