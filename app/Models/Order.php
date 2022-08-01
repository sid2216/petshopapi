<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function users()
    {
    	$this->belongsTo(User::class);
    }

    public function order_statuses()
    {
    	$this->hasMany(Order_status::class);
    }
}
