<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedEmailAdmin extends Notification
{
    use Queueable;

    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load(['orderItems', 'addresses.city', 'addresses.country']);
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("🛒 طلب جديد #{$this->order->number} — " . config('app.name'))
            ->view('emails.order_created_admin', ['order' => $this->order]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
