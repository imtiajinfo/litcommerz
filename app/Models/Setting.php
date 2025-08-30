<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
	    'phone',
	    'facebook',
	    'twitter',
	    'linkedin',
	    'whatsapp',
	    'logo',	
	    'meta_logo',
	    'address',
	    'currency_icon',	
	    'faq',
	    'about'
    ];
}
