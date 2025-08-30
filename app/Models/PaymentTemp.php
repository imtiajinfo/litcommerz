<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTemp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'train_id',
        'details',
        'products',
    ];
}
