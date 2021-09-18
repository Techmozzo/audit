<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'dp', 'address', 'city', 'state', 'country', 'zip',
        'number_of_partners', 'number_of_clients', 'number_of_staff', 'is_verified', 'techmozzo_id'
    ];

    public function staff(){
        return $this->hasMany(User::class);
    }

}
