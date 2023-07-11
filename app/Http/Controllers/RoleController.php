<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRolePermissionsRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $roles =  Role::with('permissions:id,name')->get(['id','name', 'description']);
        $permissions = Permission::all();
        return response()->success(Response::HTTP_OK, 'Request Successful', ['roles' => $roles, 'permissions' => $permissions]);
    }

    public function update(UpdateRolePermissionsRequest $request, $roleId)
    {
        $role = Role::find($roleId);
        if(!$role){
            return response()->error(Response::HTTP_NOT_FOUND, "$role not found.");
        }
        $permissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
        $update = $role->syncPermissions($permissions);
        if (!$update) {
            return response()->error(Response::HTTP_NOT_FOUND, 'Unable to update role.');
        }
        return response()->success(Response::HTTP_OK, 'Request Successful');
    }

    public function delete($roleId)
    {
        $userHasRole = DB::table('model_has_roles')->where('role_id', $roleId)->first();
        if ($userHasRole) {
            return response()->error(Response::HTTP_BAD_REQUEST, 'A user exist with this role or a pe.');
        }
        return response()->success(Response::HTTP_OK, 'Request Successful');
    }
}
