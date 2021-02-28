<?php

namespace App\Models\Theme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    public function City(){
        return $this->HasOne(City::class,"id","city_id");
    }
    public function Quarter(){
        return $this->HasOne(Quarter::class,"id","quarter_id");
    }
    public function Neighborhood(){
        return $this->HasOne(Neighborhood::class,"id","neighborhood_id");
    }
    public function District(){
        return $this->HasOne(District::class,"id","district_id");
    }
}
