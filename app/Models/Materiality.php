<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiality extends Model
{
    use HasFactory;

    protected $fillable = ['materiality_level_id', 'planning_id', 'company_id', 'limit', 'amount','reason'];

    public function level(){
        return $this->belongsTo(MaterialityLevel::class,'materiality_level_id');
    }
}
