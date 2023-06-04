<?php

namespace App\Http\Controllers;

use App\Actions\EngagementInvite as ActionsEngagementInvite;
use App\Http\Requests\EngagementInvitationRequest;
use App\Models\EngagementInvite;
use App\Traits\HashId;
use Symfony\Component\HttpFoundation\Response;

class EngagementInviteController extends Controller
{
    use HashId;

    public function send(EngagementInvitationRequest $request, $engagementId, ActionsEngagementInvite $invite)
    {
        return $invite->send($request, $engagementId);
    }

    public function accept($token)
    {
        $token = $this->decrypt($token);
        $user = auth()->user();
        $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invalid Token');
        if (isset($token['data_id'])) {
            $invite = EngagementInvite::where('id', $token['data_id'])->where([['user_id', $user->id], ['status', 0]])->first();
            $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invitation does not exist.');
            if ($invite !== null) {
                $user->engagementRole()->attach($invite->engagement_team_role_id, ['engagement_id' => $invite->engagement_id, 'created_at' => now(), 'updated_at' => now(), 'company_id' => $user->company_id]);
                $invite->update(['status' => 1]);
                $response = response()->success(Response::HTTP_CREATED, 'Invitation Accepted');
            }
        }
        return $response;
    }


    public function decline($token)
    {
        $token = $this->decrypt($token);
        $user = auth()->user();
        $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invalid Token');
        if (isset($token['data_id'])) {
            $invite = EngagementInvite::where('id', $token['data_id'])->where([['user_id', $user->id], ['status', 0]])->first();
            $response = response()->error(Response::HTTP_BAD_REQUEST, 'Invitation does not exist.');
            if ($invite !== null) {
                $invite->update(['status' => 2]);
                $response = response()->success(Response::HTTP_CREATED, 'Invitation Declined');
            }
        }
        return $response;
    }
}
