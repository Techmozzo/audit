<?php


namespace App\Interfaces;


interface RegistrationInterface
{
    public function admin(array $request):array;

    public function company(array $request);
}
