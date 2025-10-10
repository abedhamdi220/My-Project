<?php

namespace App\Http\Servicses\Admin;

use App\Models\User;

class NotificationService {
      public function listNotifications(User $user){
        return $user->notifications()->paginate(10);
        
    }
    public function getUnreadCount(User $user){
        return $user->unreadNotifications()->count();
       

    }
    public function markAllAsread(User $user){
         return $user->unreadNotifications()->markAsRead();
       
    }
}