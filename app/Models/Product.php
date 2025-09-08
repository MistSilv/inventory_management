<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'nazwa',
        'id_abaco',
    ];

    public function eanCodes()
    {
        return $this->hasMany(EanCode::class, 'produkt_id');
    }
}
