<?php

namespace App\Models\Theme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $table = "users";
    use HasFactory;
    public function Address(){
        return $this->hasMany(UserAddress::class,"user_id","id")->with("City")->with("District")->with("Neighborhood")->with("Quarter");
    }
    public function Favourite(){
        return $this->belongsToMany(Product::class,FavouriteProduct::class,"user_id","products_id","id")->with("CoverPhotos")->with("category")->with("FavouriteControl");
    }
}
