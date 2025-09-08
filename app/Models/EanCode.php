<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EanCode extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'produkt_id',
        'kod_ean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'produkt_id');
    }
}
