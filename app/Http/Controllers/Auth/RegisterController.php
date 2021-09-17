<?php

namespace App\Http\Controllers\Auth;

use App\Actions\CreateUser;
use \App\Services\Concretes\Registration;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Services\Interfaces\RegistrationInterface;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __invoke(RegistrationRequest $request, Registration $registration, CreateUser $createUser){
        $user = $registration->register($createUser, $request->all());
        $data = [
            'access_token' => auth()->guard()->login($user),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new UserResource($user)
        ];
        return response()->success(Response::HTTP_CREATED, 'Registration Successful', $data);
    }
}
