<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DiscountCode;
use App\Models\OrderAddress;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_id',
        'discount_code_id',
        'cookie_id',
        'payment_method',
        'status',
        'payment_status',
        'order_status_id',
        'return_order',
        'note',
        'totalBeforeDiscount',
        'total_price',
        'shipping_price',
    ];

    protected static function booted()
    {
        static::creating(function (Order $order) {
            $order->number = Order::getNextOrderNumber();
        });
    }

    // many to many (الاوردر يحتوى على اكثر من منتج والمنتج ممكن يكون في اكتر من اودر)

    public static function getNextOrderNumber()
    {
        $year = date('Y'); // or Carbon::now()->year()
        $number = Order::whereYear('created_at', $year)->max('number');

        if ($number) {
            return $number + 1; // this will be the next number
        }
        return $year . '000001';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->withDefault([
                'first_name' => 'زائر'
            ]);
    }

    public function guest()
    {
        return $this->belongsTo(\App\Models\Guest::class, 'guest_id', 'id');
    }

    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class, 'discount_code_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(\App\Models\PaymentTransaction::class, 'order_id', 'id');
    }

    public function latestTransaction()
    {
        return $this->hasOne(\App\Models\PaymentTransaction::class, 'order_id', 'id')->latestOfMany();
    }

    /**
     * Get the display name for the order owner (user or guest).
     */
    public function getCustomerNameAttribute(): string
    {
        if ($this->user_id && $this->user) {
            return trim($this->user->first_name . ' ' . $this->user->family_name);
        }
        if ($this->guest_id && $this->guest) {
            return trim($this->guest->first_name . ' ' . $this->guest->family_name) ?: 'زائر';
        }
        // fallback: read from order address
        $addr = $this->addresses()->first();
        return $addr ? trim($addr->first_name . ' ' . $addr->last_name) : 'زائر';
    }

    public function getCustomerEmailAttribute(): string
    {
        if ($this->user_id && $this->user) {
            return $this->user->email ?? '—';
        }
        if ($this->guest_id && $this->guest) {
            return $this->guest->email ?? '—';
        }
        $addr = $this->addresses()->first();
        return $addr?->email ?? '—';
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id')
            ->using(OrderItem::class)
            ->as('order_items')
            ->withPivot([
                'product_name', 'price', 'quantity',
            ]);
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class, 'order_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'id');
    }

    public function scopeFilter(Builder $builder, $orderNumber)
    {
        $builder->when($orderNumber ?? false, function ($builder, $value) {

            $builder->where('orders.number', 'LIKE', "%{$value}%");
        });
    }

    public function billingAddress()
    {
        // will return colleciton
        // return $this->addresses()->where('type', '=', 'billing');
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', '=', 'billing');
    }

    public function shippingAddress()
    {
        // will return colleciton
        // return $this->addresses()->where('type', '=', 'shipping');
        return $this->hasOne(OrderAddress::class, 'order_id', 'order')
            ->where('type', '=', 'shipping');
    }


    public function choices()
    {
        return $this->belongsToMany(Choice::class, 'order_choices')
            ->withPivot('sub_choice_id')
            ->withTimestamps();
    }
}
