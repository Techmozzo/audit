<?php

namespace App\Http\Controllers;

use App\Actions\UpdateUser;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function profile(){
        $user = User::where('id', auth()->id())->with('role:name,description')->first();
        return response()->success(Response::HTTP_OK, 'Request Successful', ['user' => $user]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $response = response()->success(Response::HTTP_NOT_FOUND, 'User does not exist.');
        $user = User::where('id', auth()->id())->first();
        if ($user !== null) {
            $url = [];
            if(isset($request->dp)) $url['dp'] = $storeImageToCloud($request->dp);
            $user->update($request->except(['dp','is_verified','email', 'company_id']) + $url);
            $response = response()->success(Response::HTTP_ACCEPTED, 'Update Successful', ['user' => $user]);
        }
        return $response;
    }
}
