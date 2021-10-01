<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        return response()->success(Response::HTTP_OK, 'Request Successful', ['roles' => Role::get(['name', 'description'])]);
    }

}
