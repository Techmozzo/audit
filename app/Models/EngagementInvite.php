<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngagementInvite extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'user_id','engagement_id', 'engagement_team_role_id','company_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function engagement(){
        return $this->belongsTo(Engagement::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function role(){
        return $this->belongsTo(EngagementTeamRoles::class, 'engagement_team_role_id');
    }
}
