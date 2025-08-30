<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockSummery extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'product_id',
        'quantity',
        'amount',
        'sell_price',
    ];
}
