<?php

/* This is an example, more functionality can be added */

namespace Lester\ProactiveAlert\Notifications;

use Illuminate\Notifications\Notification;
use Lester\ProactiveAlert\Channels\ProactiveAlert;
use Lester\ProactiveAlert\Messages\ProactiveMessage;

class ProactiveNotification extends Notification
{
    private $text;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    public function via($notifiable)
    {
        return [ProactiveAlert::class];
    }

    public function toProactiveAlert($notifiable)
    {
        return (new ProactiveMessage)->line($this->text)->to($notifiable->mobileNumber);
    }
}
