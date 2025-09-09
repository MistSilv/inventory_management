<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'unit',
    ];

    // Relacja do kodów EAN (jeden produkt może mieć wiele kodów)
    public function barcodes()
    {
        return $this->hasMany(Barcode::class);
    }

    // Relacja do pozycji spisu (stocktaking_items)
    public function stocktakingItems()
    {
        return $this->hasMany(StocktakingItem::class);
    }
}
