<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureAssertion extends Model
{
    use HasFactory;

    protected $fillable = ['procedure_id', 'assertion_id', 'value'];

    protected $table = 'procedure_assertions';

}
