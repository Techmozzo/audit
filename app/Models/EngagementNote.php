<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngagementNote extends Model
{
    use HasFactory;

    protected $fillable = ['message','engagement_note_flag_id','engagement_stage_id','engagement_id','user_id','company_id'];

    public function flag(){
        return $this->belongsTo(EngagementNoteFlag::class, 'engagement_note_flag_id');
    }

    public function stage(){
        return $this->belongsTo(EngagementStage::class, 'engagement_stage_id');
    }

    public function engagement(){
        return $this->belongsTo(Engagement::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
