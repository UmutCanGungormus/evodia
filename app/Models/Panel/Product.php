<?php

namespace App\Models\Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = "id";
    protected $guarded = [];
    use HasFactory;

    public function product(){
        return $this->hasMany(ProductCategories::class, 'product_id', "id");
    }
    public function category(){
        return $this->hasManyThrough( ProductCategory::class,ProductCategories::class,"product_id","id");
    }
}
