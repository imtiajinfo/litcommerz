<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'slug',
        'buy_price',
        'sell_price',
        'available_stock',
        'category_id',
        'subcategory_id',
        'brand',
        'description',
        'short_description',
        'status',
        'offer_category_id',
        'offer_amount',
        'unit',
        'weight',
        'note',
        'sl'
    ];

    public function first_img(){
        return $this->hasOne(ProductImages::class);
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function subcategory() {
        return $this->belongsTo(SubCategory::class);
    }
    public function product_images(){
        return $this->hasMany(ProductImages::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function units()
    {
        return $this->hasOne(Unit::class, 'id', 'unit');
    }
    public function brands()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products', 'product_id', 'category_id')
            ->withPivot('subcategory_id', 'sl');
    }

    public function subcategories()
    {
        return $this->belongsToMany(SubCategory::class, 'category_products', 'product_id', 'subcategory_id');
    }

    public function offerProduct()
    {
        return $this->hasOne(OfferProduct::class, 'product_id', 'id');
    }

    public function getNewPriceAttribute()
    {
        $offerProduct = $this->offerProduct;

        if (!$offerProduct) {
            return $this->sell_price;
        }

        if ($offerProduct->is_percentage == 1) {
            $discount = ($this->sell_price * $offerProduct->percentage) / 100;
        } else {
            $discount = $offerProduct->amount;
        }

        $newPrice = $this->sell_price - $discount;

        return max(0, $newPrice);
    }
}
