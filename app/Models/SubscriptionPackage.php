<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','monthly_price','annual_price','feature'];

    public function getFeatureAttribute($value){
        return json_decode($value);
    }
}
