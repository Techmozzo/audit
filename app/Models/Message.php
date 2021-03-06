<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['company_id', 'client_id', 'user_id','title','message','sender','status'];

    public function documents(){
        return $this->hasMany(MessageDocument::class);
    }
}
