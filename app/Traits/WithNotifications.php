<?php

namespace App\Traits;

trait WithNotifications
{
    public $showNotification = false;
    public $notificationMessage = '';

    public function showNotification(string $message)
    {
        $this->notificationMessage = $message;
        $this->showNotification = true;
    }

    public function hideNotification()
    {
        $this->showNotification = false;
        $this->notificationMessage = '';
    }
} 