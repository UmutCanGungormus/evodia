<?php

namespace App\Models\Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    protected $table="product_category";

    use HasFactory;
    public function category(){
        return $this->hasOne(ProductCategory::class, 'id', "category_id");
    }
}
