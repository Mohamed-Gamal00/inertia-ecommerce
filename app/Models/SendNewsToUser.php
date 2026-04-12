<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SendNewsToUser extends Model
{
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $table = 'send_news_to_users';
    protected $fillable = ['subscription_email'];

    /**
     * Route notifications for the mail channel.
     * Laravel needs this to know which email address to send to.
     */
    public function routeNotificationForMail(): string
    {
        return $this->subscription_email;
    }
}
