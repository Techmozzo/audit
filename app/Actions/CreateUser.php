<?php


namespace App\Actions;

use App\Models\User;

class CreateUser
{
    public function __invoke($company_id, $request): object
    {
        return User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => bcrypt($request['password']),
            'company_id' => $company_id,
            'designation' => isset($request['designation'])? $request['designation']: null
        ]);
    }
}
