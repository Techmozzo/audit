<?php

namespace App\Jobs;

use App\Mail\SendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EngagementInvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * UserInvitationJob constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = 'Engagement Invite.';
        $heading = 'You have been Invited to ' . $this->data->invite->engagement->name . ' Engagement';
        $body = $this->data->invite->company->name . " Has invited you to join the audit team for " . $this->data->invite->engagement->name . " Engagement as a " . $this->data->role->name .
            "<br/><br/><b><a href=http://localhost:3000/engagements/accept-invite/" . $this->data->token . ">Accept Invitation</a></b><br />
            If the button doesn't work, copy and paste the URL in your browser's address bar: <br /> <br />
            href=http://localhost:3000/engagements/accept-invite/" . $this->data->token . "
            <br/><br/><b><a href=http://localhost:3000/engagements/decline-invite/" . $this->data->token. ">Decline Invitation</a></b><br />
            href=http://localhost:3000/engagements/decline-invite/" . $this->data->token . "
            <br/><br/>Reach out to Techmozzo Support if you have any complaints or enquiries. <br/><br/> Thanks.";
        Mail::to($this->data->invite->user->email)->send(new SendEmail($this->data->invite->user->first_name, $subject, $heading, $body));
    }
}
