<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'order_number', 'status', 'payment_status', 'fulfillment_status', 'contact_email', 'currency', 'subtotal', 'shipping_total', 'discount_total', 'tax_total', 'total', 'shipping_address', 'placed_at'];
    protected function casts(): array { return ['subtotal' => 'decimal:2', 'shipping_total' => 'decimal:2', 'discount_total' => 'decimal:2', 'tax_total' => 'decimal:2', 'total' => 'decimal:2', 'shipping_address' => 'array', 'placed_at' => 'datetime']; }
    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class); }
    public function payment() { return $this->hasOne(Payment::class); }
    public function histories() { return $this->hasMany(OrderStatusHistory::class); }
}
