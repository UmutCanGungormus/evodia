<?php

namespace App\Models\Theme;

use App\Models\Theme\ProductCategories;
use App\Models\Theme\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table="product_categories";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function product(){
        return $this->belongsToMany(Product::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class,ProductCategories::class,"category_id")->with("CoverPhoto");
    }
    public function productss()
    {
        return $this->hasManyThrough( ProductCategory::class,ProductCategories::class,"product_id","id");
    }

}
