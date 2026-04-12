<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderForVendorNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Order $order
    ) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];
        if (! empty($notifiable->email) && filter_var($notifiable->email, FILTER_VALIDATE_EMAIL)) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('طلب جديد — #'.$this->order->number)
            ->line('لديك طلب جديد في متجرك.')
            ->line('رقم الطلب: '.$this->order->number)
            ->action('عرض الطلب', url(route('vendor.orders.show', $this->order->id)));
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'طلب جديد',
            'body' => 'طلب رقم #'.$this->order->number.' — اطلع عليه وحدّث حالة التجهيز.',
            'url' => route('vendor.orders.show', $this->order->id),
            'order_id' => $this->order->id,
            'order_number' => $this->order->number,
        ];
    }
}
