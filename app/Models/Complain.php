<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'order_no',
        'inquery',
        'status',
        'message',
        'image'
    ];
}
