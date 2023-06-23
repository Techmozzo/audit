<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EngagementInviteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $accept = env('FRONTEND_APP_URL').'/app/engagements/accept-invite/'. $this->data->token;
        $decline = env('FRONTEND_APP_URL').'/app/engagements/decline-invite/'. $this->data->token;
        $link = '';
        return (new MailMessage)
        ->subject('Invite to ' . $this->data->invite->engagement->name . ' Engagement')
        ->from('support@ea-audit.com', 'Techmozzo')
        ->greeting('Hello ' . $this->data->invite->user->first_name . '!')
        ->line($this->data->invite->company->name . " Has invited you to join the audit team for " . $this->data->invite->engagement->name . " Engagement as a " . $this->data->role->name)
        ->action('Accept', $accept)
        ->line("Decline Invitation by clicking <a href=$decline target=_blank> here. </a>")
        ->line('Reach out to Techmozzo Support if you have any complaints or enquiries.')
        ->salutation('Thanks')
        ->markdown('notifications.mail', compact('notifiable'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $link = env('APP_URL')."/app/engagements/".encrypt($this->data->invite->engagement->id)."/invites/".encrypt($this->data->invite->id);
		return [
			'link' => $link,
			'title' => 'Invite to' . $this->data->invite->engagement->name . ' Engagement',
			'type' => 'invitation',
		];
    }
}
