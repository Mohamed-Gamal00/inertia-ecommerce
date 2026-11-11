<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending    = 'pending';
    case Confirmed  = 'confirmed';
    case Processing = 'processing';
    case Shipped    = 'shipped';
    case Delivered  = 'delivered';
    case Cancelled  = 'cancelled';

    /** Arabic label */
    public function labelAr(): string
    {
        return match($this) {
            self::Pending    => 'قيد الانتظار',
            self::Confirmed  => 'تم التأكيد',
            self::Processing => 'قيد التجهيز',
            self::Shipped    => 'تم الشحن',
            self::Delivered  => 'تم التسليم',
            self::Cancelled  => 'ملغي',
        };
    }

    /** English label */
    public function labelEn(): string
    {
        return match($this) {
            self::Pending    => 'Pending',
            self::Confirmed  => 'Confirmed',
            self::Processing => 'Processing',
            self::Shipped    => 'Shipped',
            self::Delivered  => 'Delivered',
            self::Cancelled  => 'Cancelled',
        };
    }

    /** Locale-aware label */
    public function label(): string
    {
        return app()->getLocale() === 'ar' ? $this->labelAr() : $this->labelEn();
    }

    /** Bootstrap badge colour for admin views */
    public function badgeColor(): string
    {
        return match($this) {
            self::Pending    => 'warning',
            self::Confirmed  => 'primary',
            self::Processing => 'info',
            self::Shipped    => 'secondary',
            self::Delivered  => 'success',
            self::Cancelled  => 'danger',
        };
    }

    /** Whether the customer can still request a return */
    public function canReturn(): bool
    {
        return $this === self::Pending;
    }

    /** All cases as a select-box array [value => label] */
    public static function options(): array
    {
        return array_column(
            array_map(fn(self $s) => ['value' => $s->value, 'label' => $s->label()], self::cases()),
            'label',
            'value'
        );
    }
}
