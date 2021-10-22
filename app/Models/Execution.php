<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Execution extends Model
{
    use HasFactory;

    protected $fillable = ['engagement_id','company_id','contract_agreement_review','legal_counsel_review','contingent_liability_review','party_transaction_review','expert_work_review','other_estimate_review'];
}
