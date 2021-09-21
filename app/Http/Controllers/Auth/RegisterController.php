<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Services\Interfaces\RegistrationInterface;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    private $registration;

    public function __construct(RegistrationInterface $registration)
    {
        $this->registration = $registration;
    }

    public function __invoke(RegistrationRequest $request){
        $data = $this->registration->execute($request->all());
        return response()->success(Response::HTTP_CREATED, 'Registration Successful', $data);
    }
}
