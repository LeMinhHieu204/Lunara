<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'value', 'is_active', 'starts_at', 'ends_at', 'usage_limit', 'usage_count'];
    protected function casts(): array { return ['value' => 'decimal:2', 'is_active' => 'boolean', 'starts_at' => 'datetime', 'ends_at' => 'datetime']; }
    public function discount(float $subtotal): float { return $this->type === 'percent' ? round($subtotal * ((float) $this->value / 100), 2) : min($subtotal, (float) $this->value); }
    public function isValid(): bool { return $this->is_active && (! $this->starts_at || $this->starts_at->isPast()) && (! $this->ends_at || $this->ends_at->isFuture()) && (! $this->usage_limit || $this->usage_count < $this->usage_limit); }
}
