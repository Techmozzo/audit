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

class MessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $client, $token;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($client, $token)
    {
        $this->client = $client;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = 'Audit Message';
        $heading = 'New Message  From Techmozzo Audit Platform';
        $body = "This is to inform you that you have a new message on the Audit Platform.
        <br/><br/><b><a href=http://localhost:8000/audit-messages/".$this->token."/messages>View Message</a></b><br />
        If the button doesn't work, copy and paste the URL in your browser's address bar: <br /> <br />
        http://localhost:8000/audit-messages/".$this->token."/messages
        <br/><br/>Reach out to Techmozzo Support if you have any complaints or enquiries. <br/><br/> Thanks";
        Mail::to($this->email)->send(new SendEmail('Admin', $subject, $heading, $body));
    }
}
