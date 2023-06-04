<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UserRoleController extends Controller
{
    /**
     * @return mixed
     */
    public function companyUsersRole()
    {
        $users = User::with('role:id,name,description')->where('company_id', auth()->user()->company_id)
            ->select('id', 'first_name', 'last_name', 'email', 'phone', 'designation', 'is_verified', 'company_id')->get();
        return response()->success(Response::HTTP_OK, 'Request Successful', ['users' => $users]);
    }

    /**
     * @param RoleRequest $request
     * @return mixed
     */
    public function assignRoleToUser(RoleRequest $request)
    {
        $response = response()->error(Response::HTTP_NOT_FOUND, 'User does not exist');
        $user = User::where([['id', $request->user_id], ['company_id', auth()->user()->company_id]])->first();
        if ($user !== null) {
            $existingRoles = $user->role()->pluck('role_id')->toArray();
            foreach ($request->role_id as $newRole) {
                if (!in_array($newRole, $existingRoles)) {
                    $user->role()->attach($newRole, ['created_at' => now(), 'updated_at' => now()]);
                }
            }
            $response = response()->success(Response::HTTP_OK, 'Role(s) assigned successful');
        }
        return $response;
    }

    /**
     * @param RoleRequest $request
     * @return mixed
     */
    public function removeRoleFromUser(RoleRequest $request)
    {
        $response = response()->error(Response::HTTP_NOT_FOUND, 'User does not exist');
        $user = User::where([['id', $request->user_id], ['company_id', auth()->user()->company_id]])->first();
        if ($user !== null) {
            $existingRoles = $user->role()->pluck('role_id')->toArray();
            foreach ($request->role_id as $roleToRemove) {
                if (in_array($roleToRemove, $existingRoles)) {
                    $user->role()->detach($roleToRemove, ['created_at' => now(), 'updated_at' => now()]);
                }
            }
            $response = response()->success(Response::HTTP_OK, 'Role(s) removed successful');
        }
        return $response;
    }
}
