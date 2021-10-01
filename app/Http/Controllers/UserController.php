<?php

namespace App\Http\Controllers;

use App\Actions\StoreImageToCloud;
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
    public function update(Request $request, StoreImageToCloud $storeImageToCloud, UpdateUser $updateUser)
    {
        $response = response()->success(Response::HTTP_NOT_FOUND, 'User does not exist.');
        $user = User::where('id', auth()->id())->first();
        if ($user !== null) {
            $updateUser($request, $user, $storeImageToCloud);
            $response = response()->success(Response::HTTP_ACCEPTED, 'Update Successful', ['user' => $user]);
        }
        return $response;
    }
}
