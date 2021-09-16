<?php

namespace App\Http\Controllers\Auth;

use App\Actions\CreateUser;
use App\Actions\Registration;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __invoke(RegistrationRequest $request, Registration $register){
        $data = $register($request, new CreateUser());
        return response()->success(Response::HTTP_CREATED, 'Registration Successful', $data);
    }
}
