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

class InvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data, $role;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $role)
    {
        $this->data = $data;
        $this->role = $role;
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
        $body = $this->data['company_name']. ' Has created an audit profile on Techmozzo audit and has invited you as their '. $this->role
                                     .'<br/><br/>Reach out to Techmozzo Support if you have any complaints or enquiries. <br/><br/> Thanks';
        Mail::to($this->data['managing_partner_email'])->send(new SendEmail($this->data['managing_partner_name'], $subject, $heading, $body));

    }
}
