<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
    	'order_status_id',
        'amount',
        'uuid',
        'products',
        'address',
        'delivary_fee',
         'payment_id'
    ];

    public function users()
    {
    	return $this->belongsToMany(User::class);
    }

    public function order_statuses()
    {
    	return $this->hasMany(Order_status::class);
    }
}
