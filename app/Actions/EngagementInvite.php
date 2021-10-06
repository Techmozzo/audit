<?php

namespace App\Actions;

use App\Jobs\EngagementInvitationJob;
use App\Models\Engagement;
use App\Models\EngagementInvite as Invite;
use App\Models\EngagementTeamRole;
use App\Traits\HashId;
use Symfony\Component\HttpFoundation\Response;

class EngagementInvite
{

    use HashId;

    public function send($request, $engagementId)
    {
        $response = response()->error(Response::HTTP_NOT_FOUND, 'Engagement does not exist.');
        $engagement = Engagement::where([['id', $engagementId], ['company_id', auth()->user()->company_id]])->first();
        if ($engagement !== null) {
            $response = response()->error(Response::HTTP_NOT_FOUND, 'User Has already been Invited.');
            if ($this->checkExistingInvite($request->user_id, $engagementId) == null) {
                $invite = Invite::create($request->all() + ['engagement_id' => $engagementId]);
                $role = EngagementTeamRole::find($request->engagement_team_role_id);
                $response = response()->error(Response::HTTP_NOT_FOUND, 'Role does not exist.');
                if ($role !== null) {
                    $data = (object)['token' => $this->encrypt($invite->id)['data_token'], 'invite' => $invite, 'role' => $role];
                    EngagementInvitationJob::dispatch($data)->onQueue('audit_queue');
                    // EngagementInvitationAdminJob::dispatch($data, 'Admin Email')->onQueue('audit_queue');
                    $response = response()->success(Response::HTTP_OK, 'Invite sent successfully', ['invite' => $invite]);
                }
            }
        }
        return $response;
    }

    private function checkExistingInvite($userId, $engagementId)
    {
        $existingInvite = Invite::where([['user_id', $userId], ['engagement_id', $engagementId]])->whereIn('status', [0, 1])->first();
        return $existingInvite;
    }
}
