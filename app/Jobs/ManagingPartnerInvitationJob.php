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

class ManagingPartnerInvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data, $role, $token;

    /**
     * ManagingPartnerInvitationJob constructor.
     * @param $data
     * @param $role
     * @param $token
     */
    public function __construct($data, $role, $token)
    {
        $this->data = $data;
        $this->role = $role;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = $this->data['company_name'] . ' Audit Invite.';
        $heading = 'Audit Invite';
        $body = $this->data['company_name']. " Has created an audit profile on Techmozzo audit and has invited you as their $this->role
            <br/><br/><b><a href=".env('FRONTEND_APP_URL')."/invited-user-registration/$this->token>Accept Invitation</a></b><br />
            If the button doesn't work, copy and paste the URL in your browser's address bar: <br /> <br />
            ".env('FRONTEND_APP_URL')."/invited-user-registration/$this->token
            <br/><br/>Reach out to Techmozzo Support if you have any complaints or enquiries. <br/><br/> Thanks.";
        Mail::to($this->data['managing_partner_email'])->send(new SendEmail($this->data['managing_partner_name'], $subject, $heading, $body));

    }
}
