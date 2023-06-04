<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function update(Request $request, $roleId)
    {
        $update = Role::where('id', $roleId)->update($request->all());
        if(!$update){
            return response()->error(Response::HTTP_NOT_FOUND, 'Unable to update role.');
        }
        return response()->success(Response::HTTP_OK, 'Request Successful');
    }

    public function delete($roleId)
    {
        $userHasRole = DB::table('model_has_roles')->where('role_id', $roleId)->first();
        if($userHasRole){
            return response()->error(Response::HTTP_BAD_REQUEST, 'A user exist with this role or a pe.');
        }
        return response()->success(Response::HTTP_OK, 'Request Successful');
    }

}
