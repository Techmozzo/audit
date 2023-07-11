<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionClass extends Model
{
    use HasFactory;
    protected $fillable = ['planning_id', 'company_id', 'name', 'process_flow_document', 'work_through', 'risk_material_misstatement'];

    public function procedures(){
        return $this->hasMany(Procedure::class, 'transaction_class_id');
    }
}
