<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_class_id','company_id','name','description', 'other_info'];

    public function assertions(){
        return $this->belongsToMany(Assertion::class, 'procedure_assertions');
    }

    public function procedureAssertions(){
        return $this->hasMany(ProcedureAssertion::class, 'procedure_id');
    }

}
