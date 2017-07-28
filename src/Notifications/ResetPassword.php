<?php

namespace Sebastienheyd\Boilerplate\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends \Illuminate\Auth\Notifications\ResetPassword
{

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->markdown('boilerplate::notifications.email')
            ->greeting(__('boilerplate::notifications.greeting', [ 'firstname' => $notifiable->first_name ]))
            ->subject(__('boilerplate::notifications.resetpassword.subject'))
            ->line(__('boilerplate::notifications.resetpassword.intro'))
            ->action(__('boilerplate::notifications.resetpassword.button'), route('password.reset', $this->token))
            ->line(__('boilerplate::notifications.resetpassword.outro'));
    }
}
