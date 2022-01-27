<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'name', 'email', 'phone', 'address', 'registered_address', 'is_public_entity', 'nature_of_business', 'status'];

    public function engagement(){
        return $this->hasMany(Engagement::class);
    }

    public function company(){
        return $this->belongsTo(Company::class)->select('id','name', 'dp', 'address', 'city', 'state', 'country', 'zip');
    }

    public function directors(){
        return $this->hasMany(ClientDirector::class)->select('company_id', 'client_id', 'name', 'units_held', 'designation');
    }

    public function groups(){
        return $this->hasMany(ClientGroup::class)->select('company_id', 'client_id', 'name', 'percentage_holding', 'industry', 'type');
    }

}
