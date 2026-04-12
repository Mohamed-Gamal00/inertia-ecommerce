<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReturnRequestedForVendorNotification extends Notification
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
            ->subject('طلب إرجاع — #'.$this->order->number)
            ->line('قام العميل بطلب إرجاع لهذا الطلب.')
            ->line('رقم الطلب: '.$this->order->number)
            ->action('عرض الطلب', url(route('vendor.orders.show', $this->order->id)));
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'طلب إرجاع',
            'body' => 'العميل طلب إرجاعاً للطلب #'.$this->order->number.'. راجع التفاصيل واتبع سياسة الإرجاع.',
            'url' => route('vendor.orders.show', $this->order->id),
            'order_id' => $this->order->id,
            'order_number' => $this->order->number,
            'type' => 'return_request',
        ];
    }
}
