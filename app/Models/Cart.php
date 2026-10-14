<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'session_id', 'status', 'currency'];
    public function items() { return $this->hasMany(CartItem::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function subtotal(): float { return (float) $this->items->sum(fn ($item) => $item->quantity * $item->unit_price); }
}
