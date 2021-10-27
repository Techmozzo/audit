<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRegistrationRequest;
use App\Http\Requests\CompanyRegistrationRequest;
use App\Services\Interfaces\RegistrationInterface;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    private $register;

    public function __construct(RegistrationInterface $registration)
    {
        $this->register = $registration;
    }

    public function admin(AdminRegistrationRequest $request){
        $data = $this->register->admin($request->all());
        return response()->success(Response::HTTP_CREATED, 'Registration Successful', $data);
    }


    public function company(CompanyRegistrationRequest $request){
        $data = $this->register->company($request->all());
        return response()->success(Response::HTTP_CREATED, 'Registration Successful', $data);
    }
}
