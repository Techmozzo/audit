<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function package(): object
    {
        return $this->belongsTo(SubscriptionPackage::class, 'subscription_package_id')->select('name','feature');
    }
}
