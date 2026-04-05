<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'moyasar_payment_id',
        'status',
        'amount',
        'currency',
        'payment_method',
        'card_brand',
        'card_last_four',
        'description',
        'raw_response',
        'ip_address',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'paid'      => 'مدفوع',
            'failed'    => 'فاشل',
            'initiated' => 'قيد التنفيذ',
            'authorized'=> 'مُصرَّح',
            default     => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'paid'      => 'success',
            'failed'    => 'danger',
            'initiated' => 'warning',
            default     => 'secondary',
        };
    }
}
