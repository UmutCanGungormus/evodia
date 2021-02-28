<?php

namespace App\Models\Theme;

use App\Models\Theme\ProductCategories;
use App\Models\Theme\ProductCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = "id";
    protected $guarded = [];
    use HasFactory;

    public function CoverPhoto()
    {
        return $this->hasOne(ProductImage::class, "product_id", "id")->where("isCover", 1);
    }

    public function CoverPhotos()
    {
        return $this->hasMany(ProductImage::class, "product_id", "id")->where("isCover", 1);
    }

    public function OptionCategoriesOld()
    {
        return $this->belongsToMany(OptionCategory::class, Option::class, "product_id", "category_id")->with("Options")->distinct('options.category_id');
    }

    public function OptionCategories()
    {
        return $this->belongsToMany(OptionCategory::class, Option::class, "product_id", "category_id", "id")->distinct('options.category_id');
    }

    public function Photos()
    {
        return $this->hasMany(ProductImage::class, "product_id", "id");
    }

    public function Options()
    {
        return $this->hasMany(Option::class, "product_id", "id");
    }

    public function category()
    {
        return $this->belongsToMany(ProductCategory::class, ProductCategories::class, "product_id", "category_id")->withCasts(["price" => "integer"]);
    }

    public function FavouriteControl()
    {
        if (Session::has("user")) {
            return $this->hasOne(FavouriteProduct::class, "products_id", "id")->where("user_id", Session::get("user")->id);
        } else {
            return $this->hasOne(FavouriteProduct::class, "products_id", "id")->where("user_id", null);
        }
    }

    public function OpCat()
    {
        return $this->HasMany(OptionCategory::class, Option::class, "product_id", "category_id");
    }

    public function oldFunction()
    {
        return $this->hasManyThrough(ProductCategory::class, ProductCategories::class, "product_id", "id");
    }

}

