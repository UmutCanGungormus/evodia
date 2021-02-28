<?php

namespace App\Models\Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    protected $table = 'languages';
    protected $primaryKey = "id";
    protected $guarded = [];
    use HasFactory;

}
