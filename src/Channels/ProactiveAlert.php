<?php

namespace Lester\ProactiveAlert\Channels;

use Illuminate\Notifications\Notification;
use Lester\ProactiveAlert\Facades\Proactive;

class ProactiveAlert
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toProactiveAlert($notifiable);

        // Send notification to the $notifiable instance...
        Proactive::to($message->to)->body(implode("\n", $message->introLines))->submit();
    }

}
