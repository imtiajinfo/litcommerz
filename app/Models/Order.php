<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->hasOne(User::class, 'id','user_id');
    }
    public function shipping_info(){
        return $this->hasOne(ShippingInfo::class, 'order_id','id');
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetails::class, 'order_id','id');
    }
}
