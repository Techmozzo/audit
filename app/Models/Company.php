<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'dp', 'address', 'city', 'state', 'country', 'zip'];

    public function users(): object
    {
        return $this->hasMany(User::class);
    }

    public function subscription():object
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscriptionRecord():object
    {
        return $this->hasMany(SubscriptionRecord::class);
    }

    public function client(): object
    {
        return $this->belongsTo(Client::class);
    }

    public function engagement(): object
    {
        return $this->belongsTo(Engagement::class);
    }

}
