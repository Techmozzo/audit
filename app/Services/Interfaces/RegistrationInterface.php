<?php


namespace App\Services\Interfaces;


interface RegistrationInterface
{
    public function register($createUser, $request):object;
}
