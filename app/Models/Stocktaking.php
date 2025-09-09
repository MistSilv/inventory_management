<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocktaking extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'description', 'status', 'created_by'
    ];

    protected $casts = [
        'date' => 'date', 
    ];


    // Użytkownik, który utworzył spis
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Pozycje w spisie
    public function items()
    {
        return $this->hasMany(StocktakingItem::class);
    }
}
