<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialityLevel extends Model
{
    use HasFactory;

    protected $fillable = ['name','lower_limit','upper_limit','description'];
}
