<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngagementTeamMembers extends Model
{
    use HasFactory;

    protected $table = "engagement_team_members";
    protected $fillable = ['user_id', 'engagement_team_role_id', 'company_id'];

    public function teamMemberRole(){
        return $this->belongsTo(EngagementTeamRole::class, 'engagement_team_role_id')->select('id','name','description');
    }
}
