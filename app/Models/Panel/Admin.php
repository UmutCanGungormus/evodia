<?php

namespace App\Models\Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Panel\UserRole;

class Admin extends Model
{
    protected $table="users";
    use HasFactory;
    public function Adminrole(){
        return $this->hasOne(UserRole::class,"seo_url","role");
    }
}
