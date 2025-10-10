<?php

namespace App\Http\Servicses\Client;

use Illuminate\Support\Facades\Notification;

class NotificationService
{
    public function getNotificationClient($client)
    {
        if (!$client) {
            throw new \Exception("Unauthorized: please log in as Client");
        }

        return $client->notifications()->orderBy('created_at', 'desc')->get();
    }
    public function markNotificationAsRead($client, $notificationId)
    {
        if (!$client) {
            throw new \Exception("Unauthorized: please log in as Client");
        }

        $Notification = $client->Notifications()->findOrFail($notificationId);
        $Notification->markAsRead();
        return $Notification;
    }
}
