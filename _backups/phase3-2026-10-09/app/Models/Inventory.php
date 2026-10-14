<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['product_variant_id', 'stock_on_hand', 'stock_reserved'];
    protected function casts(): array { return ['stock_on_hand' => 'integer', 'stock_reserved' => 'integer']; }
    public function variant() { return $this->belongsTo(ProductVariant::class, 'product_variant_id'); }
    public function available(): int { return max(0, $this->stock_on_hand - $this->stock_reserved); }
}
