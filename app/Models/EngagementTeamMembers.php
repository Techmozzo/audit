<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngagementTeamMembers extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'engagement_team_role_id'];
}
