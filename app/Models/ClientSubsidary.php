<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSubsidary extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'client_id', 'name', 'percentage_holding', 'nature', 'nature_of_business'];
}
