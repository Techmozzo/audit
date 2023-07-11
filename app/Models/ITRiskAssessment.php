<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ITRiskAssessment extends Model
{
    use HasFactory;

    protected $fillable = ['planning_id','company_id','status','name','function','review_performed'];
}
