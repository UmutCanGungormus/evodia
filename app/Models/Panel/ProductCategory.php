<?php

namespace App\Models\Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table="product_categories";
    use HasFactory;
    public function category(){
        return $this->hasOne(ProductCategories::class, 'category_id', "id");
    }
}
