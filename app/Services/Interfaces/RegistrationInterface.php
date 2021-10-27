<?php


namespace App\Services\Interfaces;


interface RegistrationInterface
{
    public function admin(array $request):array;

    public function company(array $request);
}
