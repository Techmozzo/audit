<?php

namespace App\Http\Controllers;

use App\Actions\EngagementInvite as ActionsEngagementInvite;
use App\Http\Requests\EngagementInvitationRequest;
use App\Jobs\EngagementInvitationAdminJob;
use App\Jobs\EngagementInvitationJob;
use App\Models\Engagement;
use App\Models\EngagementInvite;
use App\Models\EngagementTeamRoles;
use App\Traits\HashId;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EngagementInviteController extends Controller
{
    use HashId;

    public function send(EngagementInvitationRequest $request, $engagementId, ActionsEngagementInvite $invite){
        return $invite->send($request, $engagementId);
    }


    public function accept(RegisterUserRequest $request, $token, CreateUser $createUser){
        $token = $this->decrypt($token);
        $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invalid Token');
        if(isset($token['data_id'])){
            $invitedUser = UserInvitation::find($token['data_id']);
            $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invitation does not exist.');
            if($invitedUser !== null){
                $user = $createUser($invitedUser->company_id, $request->all());
                $user->role()->attach($invitedUser->role_id, ['created_at' => now(), 'updated_at' => now()]);
                $invitedUser->update(['status' => 1]);
                $data = [
                    'access_token' => auth()->guard()->login($user),
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                    'user' => new UserResource($user)
                ];
                $response = response()->success(Response::HTTP_CREATED, 'Registration Successful', $data);
            }
        }
        return $response;
    }


    public function decline(){

    }
}
