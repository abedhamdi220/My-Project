<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotifications extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $order;
    public function __construct($order)
    {
        $this->order = $order;
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
    // public function toArray(object $notifiable): array
    // {
    //     return [
    //         //
    //     ];
    // }
    public function toDatabase(object $notifiable): array
    {
        return [
            'order_id'=> $this->order->id,
            "notes"=>$this->order->notes ?? null,
            "provider_id"=>$this->order->provider_id,
            "service_name"=>$this->order->service->name,
            "client_id"=>$this->order->client_id,
            "status"=>$this->order->status,
            "message"=>"your service has been ordered by client {$this->order->client->name}"

        ];
    }
}
