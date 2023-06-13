<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends Controller
{
    public function __invoke(){

        $user = auth()->user();
        logAction([
            'name' => "Logout",
            'description' => "User Logout: ". $user->name,
            'properties' => $user->id,
            'causer_id' => $user->id
        ]);

        auth()->logout();
        return response()->success(Response::HTTP_OK, 'Successfully logged out');
    }
}
