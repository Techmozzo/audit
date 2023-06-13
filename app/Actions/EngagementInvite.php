<?php

namespace App\Actions;

use App\Models\Engagement;
use App\Models\EngagementInvite as Invite;
use App\Models\EngagementTeamRole;
use App\Models\User;
use App\Notifications\EngagementInviteNotification;
use App\Traits\HashId;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class EngagementInvite
{

    use HashId;

    public function send($request, $engagementId)
    {
        $user = auth()->user();
        $engagement = Engagement::where([['id', $engagementId], ['company_id', $user->company_id]])->first();
        if (!$engagement) {
            return response()->error(Response::HTTP_NOT_FOUND, 'Engagement does not exist.');
        }
        foreach ($request->team_members as $teamMember) {
            $teamMemberExist = User::where([['id', $teamMember['user_id']], ['company_id', $user->company_id]])->first();
            $role = EngagementTeamRole::find($teamMember['engagement_team_role_id']);
            if (!$teamMemberExist || $this->checkExistingInvite($teamMember['user_id'], $engagementId) || !$role) {
                continue;
            }
            try {
                DB::beginTransaction();
                $invite = Invite::create(['user_id' => $teamMember['user_id'], 'engagement_team_role_id' => $teamMember['engagement_team_role_id'], 'company_id' => $user->company_id, 'engagement_id' => $engagementId]);
                $data = (object)['token' => $this->encrypt($invite->id)['data_token'], 'invite' => $invite, 'role' => $role];
                $teamMemberExist->notify(new EngagementInviteNotification($data));
                // ->onQueue('audit_queue');
                DB::commit();
                //Activity Log
                
            } catch (Throwable $t) {
                DB::rollBack();
                Log::error(['Error-On-Engagement-Invite' => $t->getMessage()]);
            }
        }
        return response()->success(Response::HTTP_OK, 'Invite sent successfully');
    }

    private function checkExistingInvite($userId, $engagementId)
    {
        return Invite::where([['user_id', $userId], ['engagement_id', $engagementId]])->whereIn('status', [0, 1])->first();
    }
}
