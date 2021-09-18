<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInvitation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['email', 'name', 'status', 'company_id', 'role_id'];

}
