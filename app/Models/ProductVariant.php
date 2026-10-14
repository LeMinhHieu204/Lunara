<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'sku', 'size', 'color', 'price', 'is_default'];
    protected function casts(): array { return ['price' => 'decimal:2', 'is_default' => 'boolean']; }
    public function product() { return $this->belongsTo(Product::class); }
    public function inventory() { return $this->hasOne(Inventory::class); }
}
