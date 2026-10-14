<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'name', 'slug', 'sku', 'description', 'price', 'compare_at_price', 'material', 'status', 'featured', 'new_arrival', 'on_sale', 'rating', 'review_count', 'seo_title', 'seo_description'];
    protected function casts(): array { return ['price' => 'decimal:2', 'compare_at_price' => 'decimal:2', 'rating' => 'decimal:1', 'featured' => 'boolean', 'new_arrival' => 'boolean', 'on_sale' => 'boolean']; }
    public function category() { return $this->belongsTo(Category::class); }
    public function images() { return $this->hasMany(ProductImage::class)->orderBy('sort_order'); }
    public function variants() { return $this->hasMany(ProductVariant::class); }
    public function getImageUrlAttribute(): string { return $this->images->firstWhere('is_primary', true)?->image_url ?? $this->images->first()?->image_url ?? 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=800&q=86'; }
}
