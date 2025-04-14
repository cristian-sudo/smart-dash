<?php

namespace App\Traits;

trait WithNotifications
{
    public $show = false;
    public $notificationMessage = '';

    public function showNotification(string $message)
    {
        $this->notificationMessage = $message;
        $this->show = true;
    }

    public function hideNotification()
    {
        $this->show = false;
        $this->notificationMessage = '';
    }
} 