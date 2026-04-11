<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\PaymentTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPaidEmailAdmin extends Notification
{
    use Queueable;

    protected Order $order;
    protected PaymentTransaction $transaction;

    public function __construct(Order $order, PaymentTransaction $transaction)
    {
        $this->order       = $order->load(['orderItems', 'addresses.city', 'addresses.country']);
        $this->transaction = $transaction;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("✅ تم الدفع — طلب #{$this->order->number} — " . config('app.name'))
            ->view('emails.order_paid_admin', [
                'order'       => $this->order,
                'transaction' => $this->transaction,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
