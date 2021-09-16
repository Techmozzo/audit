<?php


namespace App\Actions;

use App\Models\User;

class CreateUser
{
    public function __invoke($company_id, $request, $role_id): object
    {
        return User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'company_id' => $company_id,
            'role_id' => $role_id,
            'designation' => $request->designation
        ]);
    }
}
