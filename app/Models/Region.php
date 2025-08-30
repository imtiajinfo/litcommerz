<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function delivery_charges()
    {
        return $this->hasMany(DeliveryCharge::class);
    }
}
