<?php

namespace Sebastienheyd\Boilerplate\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUser extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return string[]
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $currentUser = \Auth::user();

        return (new MailMessage())
            ->markdown('boilerplate::notifications.email')
            ->greeting(__('boilerplate::notifications.greeting', ['firstname' => $notifiable->first_name]))
            ->subject(__('boilerplate::notifications.newuser.subject', ['name' => config('app.name')]))
            ->line(__('boilerplate::notifications.newuser.intro', [
                'name' => $currentUser->first_name.' '.$currentUser->last_name,
            ]))
            ->action(
                __('boilerplate::notifications.newuser.button'),
                route('boilerplate.users.firstlogin', $notifiable->remember_token)
            )
            ->salutation(__('boilerplate::notifications.salutation', [
                'name' => $currentUser->first_name.' '.$currentUser->last_name,
            ]))
            ->line(__('boilerplate::notifications.newuser.outro'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
