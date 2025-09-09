<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StocktakingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'stocktaking_id',
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * Relacja do spisu (nagłówek)
     */
    public function stocktaking()
    {
        return $this->belongsTo(Stocktaking::class);
    }

    /**
     * Relacja do produktu
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relacja do logów / audytu
     */
    public function logs()
    {
        return $this->hasMany(StocktakingItemLog::class);
    }
}
