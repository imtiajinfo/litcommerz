<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'slug',
        'image',
        'home_show',
        'status',
        'sl'
    ];

    // public function sub_categories(){
    //     return $this->hasMany(SubCategory::class)->where('sub_categories.status', 1)->orderBy('sl', 'asc')->distinct('sub_categories.name');
    // }
    // public function products(){
    //     return $this->hasMany(Product::class,'category_id', 'id')->where('status', 1)->orderBy('sl', 'asc');
    // }

    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class)
            ->where('status', 1)
            ->orderBy('sl', 'asc')
            ->distinct('name');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_products', 'category_id', 'product_id')
            ->where('status', 1)
            ->orderBy('sl', 'asc')
            ->distinct('products.id');
    }

}
