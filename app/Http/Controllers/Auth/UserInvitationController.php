<?php

namespace App\Http\Controllers\Auth;

use App\Actions\CreateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\SendInviteRequest;
use App\Http\Resources\UserResource;
use App\Jobs\UserInvitationJob;
use App\Models\Role;
use App\Models\UserInvitation;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\HashId;

class UserInvitationController extends Controller
{
    use HashId;

    public function sendInvite(SendInviteRequest $request){
        $company = auth()->user()->company;
        if(!$company){
            return response()->error(Response::HTTP_NOT_FOUND, 'No company found. Create a company before inviting users');
        }
        $invitedUser = UserInvitation::create($request->all() + ['company_id' => $company->id]);
        $role = Role::find($request->role_id);
        $data = ['role' => $role->name, 'token' => $this->encrypt($invitedUser->id)['data_token'], 'company' => $company->name] + $request->all();
        // UserInvitationJob::dispatchIf( $role !== null, $data)->onQueue('audit_queue');
        UserInvitationJob::dispatchIf( $role !== null, $data);
        return response()->success(Response::HTTP_CREATED, 'Invitation sent successful', ['invitedUser' => $invitedUser]);
    }


    public function getInvitationInfo($token){
        $token = $this->decrypt($token);
        $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invalid Token');
        if(isset($token['data_id'])){
            $invitedUser = UserInvitation::find($token['data_id']);
            $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invitation does not exist.');
            if($invitedUser !== null) $response = response()->success(Response::HTTP_CREATED, 'Registration Successful', ['invitedUser' => $invitedUser]);
        }
        return $response;
    }

    public function registerInvitedUser(RegisterUserRequest $request, $token, CreateUser $createUser){
        $token = $this->decrypt($token);
        $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invalid Token');
        if(isset($token['data_id'])){
            $invitedUser = UserInvitation::find($token['data_id']);
            $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invitation does not exist.');
            if($invitedUser !== null){
                $role = Role::find($invitedUser->role_id);
                if(!$role){
                    return response()->error(Response::HTTP_BAD_REQUEST, 'Role not found.');
                }
                $user = $createUser($invitedUser->company_id, $request->all());
                $user->assignRole($role->name);
                $invitedUser->update(['status' => 1]);
                $data = [
                    'access_token' => auth()->guard()->login($user),
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                    'user' => new UserResource($user),
                    'roles' => $user->getRoleNames(),
                    'permissions' => $user->getAllPermissions(),
                ];
                $response = response()->success(Response::HTTP_CREATED, 'Registration Successful', $data);
            }
        }
        return $response;
    }

    public function getInvitedUsers(){
        $invitedUsers = UserInvitation::where('company_id', auth()->user()->company_id)->select('email', 'name', 'status', 'company_id', 'role_id')->get();
        return response()->success(Response::HTTP_CREATED, 'Registration Successful', ['invitedUsers' => $invitedUsers]);
    }

    public function getPendingInvites(){
        $pendingInvites = UserInvitation::where([['company_id', auth()->user()->company_id], ['status', 0]])->select('email', 'name', 'status', 'company_id', 'role_id')->get();
        return response()->success(Response::HTTP_CREATED, 'Registration Successful', ['pendingInvites' => $pendingInvites]);
    }
}
