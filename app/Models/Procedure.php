<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_class_id','company_id','name','description'];

    protected $with = ['assertions'];

    public function assertions(){
        return $this->belongsToMany(Assertion::class, 'procedure_assertions');
    }

}
