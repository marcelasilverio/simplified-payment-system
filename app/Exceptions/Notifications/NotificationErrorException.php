<?php

namespace App\Exceptions\Notifications;

use Exception;

class NotificationErrorException extends Exception
{
    protected const MESSAGE = "Notification Service Error";

    public function __construct()
    {
        $this->message = self::MESSAGE;
    }
}
