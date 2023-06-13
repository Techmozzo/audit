<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'action_id', 'action_type', 'causee_id', 'causer_id', 'causer_role', 'is_active', 'company_id', 'ip'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function causer()
    {
        return $this->hasOne(User::class, 'id', 'causer_id');
    }

    public function causee()
    {
        return $this->hasOne(User::class, 'id', 'causee_id');
    }
}
