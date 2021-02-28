<?php

namespace App\Models\Theme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OptionCategory extends Model
{
    protected $table="option_categories";
    use HasFactory;
    public function Options(){
        return $this->hasMany(Option::class, "category_id", "id");
    }
}
