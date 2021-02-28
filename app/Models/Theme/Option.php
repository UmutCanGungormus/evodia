<?php

namespace App\Models\Theme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table="options";

    use HasFactory;
    public function OptionCategories(){
        return $this->hasOne(Options::class, "id", "category_id");
    }
    public function Category(){
        return $this->hasOne(OptionCategory::class, "id", "category_id");
    }
}
