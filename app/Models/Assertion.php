<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assertion extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'description'];

    protected $hidden = ['pivot'];


    public function procedures(){
        return $this->belongsToMany(Procedure::class, 'procedure_assertions');
    }

}
