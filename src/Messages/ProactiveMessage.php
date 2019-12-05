<?php

namespace Lester\ProactiveAlert\Messages;

use Illuminate\Notifications\Messages\SimpleMessage;

class ProactiveMessage extends SimpleMessage
{

    public $to;

    public function to($number)
    {
        $this->to = $number;

        return $this;
    }

}
