<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = ['author_id', 'title', 'slug', 'excerpt', 'body', 'featured_image', 'status', 'published_at'];
    protected function casts(): array { return ['published_at' => 'datetime']; }
}
