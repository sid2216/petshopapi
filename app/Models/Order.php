<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function users()
    {
    	return $this->belongsToMany(User::class);
    }

    public function order_statuses()
    {
    	return $this->hasMany(Order_status::class);
    }
}
