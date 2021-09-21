<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function profile(){
        $user = auth()->user()->with('role:name,description')->get();
        return response()->success(Response::HTTP_OK, 'Request Successful', ['user' => $user]);
    }

    public function update(Request $request){

    }
}
