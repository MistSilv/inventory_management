<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StocktakingItemLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'stocktaking_item_id', 'user_id', 'action'
    ];

    public function stocktakingItem()
    {
        return $this->belongsTo(StocktakingItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
