<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function getAllUsers(){
        $users = User::with('role:id,name')->where('company_id', auth()->user()->company_id)->select('id', 'first_name', 'last_name', 'email', 'phone', 'password', 'designation', 'is_verified', 'company_id')->get();
        return response()->success(Response::HTTP_CREATED, 'Registration Successful', ['users' => $users]);
    }
}
