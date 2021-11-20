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
        $user = auth()->user();
        $response = response()->error(Response::HTTP_NOT_FOUND, 'Engagement does not exist.');
        $engagement = Engagement::where([['id', $engagementId], ['company_id', $user->company_id]])->first();
        if ($engagement !== null) {
            foreach ($request->team_members as $teamMember) {
                if ($this->checkExistingInvite($teamMember['user_id'], $engagementId) == null) {
                    $response = response()->error(Response::HTTP_NOT_FOUND, 'Role does not exist.');
                    $role = EngagementTeamRole::find($teamMember['engagement_team_role_id']);
                    if ($role !== null) {
                        $invite = Invite::create(['user_id' => $teamMember['user_id'], 'engagement_team_role_id' => $teamMember['engagement_team_role_id'], 'company_id' => $user->company_id, 'engagement_id' => $engagementId]);
                        $data = (object)['token' => $this->encrypt($invite->id)['data_token'], 'invite' => $invite, 'role' => $role];
                        EngagementInvitationJob::dispatch($data);
                        // ->onQueue('audit_queue');
                        // EngagementInvitationAdminJob::dispatch($data, 'Admin Email')->onQueue('audit_queue');
                    }
                }
            }
            $response = response()->success(Response::HTTP_OK, 'Invite sent successfully');
        }
        return $response;
    }

    private function checkExistingInvite($userId, $engagementId)
    {
        $existingInvite = Invite::where([['user_id', $userId], ['engagement_id', $engagementId]])->whereIn('status', [0, 1])->first();
        return $existingInvite;
    }
}
