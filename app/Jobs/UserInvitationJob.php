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

class UserInvitationJob implements ShouldQueue
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
        $subject = $this->data['company'] . ' Audit Invite.';
        $heading = 'Audit Invite';
        $body = $this->data['company']." Has created an audit profile on Techmozzo audit and has invited you as their ". $this->data['role']
            ."<br/><br/><b><a href=http://localhost:3000/invited-user-registration/".$this->data['token'].">Accept Invitation</a></b><br />
            If the button doesn't work, copy and paste the URL in your browser's address bar: <br /> <br />
            http://localhost:3000/invited-user-registration/".$this->data['token']."
            <br/><br/>Reach out to Techmozzo Support if you have any complaints or enquiries. <br/><br/> Thanks.";

        Mail::to($this->data['email'])->send(new SendEmail($this->data['name'], $subject, $heading, $body));
    }
}
