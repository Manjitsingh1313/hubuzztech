<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;


class Notification extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'notifications';
    protected $guarded = [];

    
    protected $fillable = [
        'title',
        'desctiption',
        'sender_id',
        'receiver_id',
        'attachment',
        'message',
        'notification_date',
        'status',
        'receiver_token',
        'sender_token'
    ];
}
