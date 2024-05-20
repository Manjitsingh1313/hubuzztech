<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;
    
    protected $connection = 'mongodb';
    protected $collection = 'commission';
    protected $guarded = [];

    
    protected $fillable = [
        'user_id',
        'commission_with_user_id',
        'property_id',
        'amount',
        'description',
        'title',
        'comm_date',
        'status',
    
    ];

}
