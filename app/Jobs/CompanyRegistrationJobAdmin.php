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

class CompanyRegistrationJobAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user, $company, $email;

    /**
     * RegistrationJobAdmin constructor.
     * @param $user
     * @param $email
     */
    public function __construct($user, $company, $email)
    {
        $this->user = $user;
        $this->company = $company;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = 'New company on Techmozzo Audit Platform';
        $heading = $this->user->name . ' registered on <b>' . $this->company->name . '</b> on Audit Platform';
        $body = "This is to inform you of a new company registration on the Audit Platform.
                            <br/><br/>Reach out to Techmozzo Support if you have any complaints or enquiries. <br/><br/> Thanks";
        Mail::to($this->email)->send(new SendEmail('Admin', $subject, $heading, $body));
    }
}
