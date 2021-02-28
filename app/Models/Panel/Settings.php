<?php

namespace App\Models\Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Settings extends Model
{
    protected $table = 'settings';
    protected $primaryKey = "id";
    protected $guarded = [];
    use HasFactory;
    public function languages()
    {
        return $this->hasOne(Languages::class, 'code', "language");
    }
}
