<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conclusion extends Model
{
    use HasFactory;

    protected $fillable = [
        'engagement_id', 'company_id','overall_analytical_review','going_concern_procedures','subsequent_procedures','management_representation_letter',
        'management_letter','audit_summary_misstatement','audit_report','audited_financial_statement','other_financial_info','status'
    ];
}
