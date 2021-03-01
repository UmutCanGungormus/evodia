<?php

namespace App\Models\Theme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class DiscountCoupon extends Model
{
    use HasFactory;
    public function UserCoupon(){
        return $this->HasMany(UserCopuon::class,"coupon_id","id")->where("user_id",Session::get("user")->id);
    }
}
