<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusChangeNotifications extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $newStatus;
    protected $order;
    protected $oldStatus;
    public function __construct($order, $newStatus,$oldStatus)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */

      public function toDatabase(object $notifiable): array
    {
        return [
            "order_id"=>$this->order->id,
            "status"=>$this->oldStatus,
            "message"=>"your order status  {$this->order->id} has been changed to {$this->newStatus} "
            
        ];
    }
    // public function toArray(object $notifiable): array
    // {
    //     return [
            
    //     ];
    // }
}
