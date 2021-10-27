<?php


namespace App\Actions;

use App\Models\User;

class CreateAdmin
{
    public function __invoke($request): object
    {
        return User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => bcrypt($request['password']),
        ]);
    }
}
