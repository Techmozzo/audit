<?php

namespace App\Http\Controllers\Auth;

use App\Actions\CreateUser;
use App\Actions\Registration;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __invoke(RegistrationRequest $request, Registration $register, CreateUser $createUser){
        $user = $register($request, $createUser);
        $data = [
            'access_token' => auth()->guard()->login($user),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new UserResource($user)
        ];
        return response()->success(Response::HTTP_CREATED, 'Registration Successful', $data);
    }
}
