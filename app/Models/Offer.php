<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Offer extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'banner',
        'start_date',
        'end_date',
        'home_show',
        'status',
        'sl'
    ];

    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($offer) {
    //         $baseSlug = Str::slug($offer->name);
    //         $slug = $baseSlug;
    //         $count = 1;

    //         while (self::where('slug', $slug)->exists()) {
    //             $slug = $baseSlug . '-' . $count++;
    //         }

    //         $offer->slug = $slug;
    //     });
    // }

    public function offerProducts()
    {
        return $this->hasMany(OfferProduct::class, 'offer_id');
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            OfferProduct::class,
            'offer_id',
            'id',
            'id',
            'product_id'
        );
    }
}
