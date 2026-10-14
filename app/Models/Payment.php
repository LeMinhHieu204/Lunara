<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id', 'provider', 'provider_reference', 'status', 'amount', 'payload'];
    protected function casts(): array { return ['amount' => 'decimal:2', 'payload' => 'array']; }
    public function order() { return $this->belongsTo(Order::class); }
}
