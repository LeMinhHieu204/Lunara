<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $category = BlogCategory::where('slug', 'style-notes')->first();
        foreach ([
            ['title' => 'The quiet power of a considered wardrobe', 'slug' => 'quiet-power-considered-wardrobe', 'excerpt' => 'A few good pieces can create more ease in the everyday.', 'body' => "Getting dressed should feel like a small act of clarity. Start with pieces that work together, move with you and earn their place through repeat wear.", 'featured_image' => '/assets/lunara/hero-rack.png'],
            ['title' => 'How to make neutrals feel personal', 'slug' => 'how-to-make-neutrals-feel-personal', 'excerpt' => 'Texture, proportion and the details that make a quiet palette your own.', 'body' => "Neutrals are never one-note. Mix texture, soften structure and let one thoughtful detail carry the story.", 'featured_image' => '/assets/lunara/linen-shirt.png'],
        ] as $post) BlogPost::updateOrCreate(['slug' => $post['slug']], $post + ['blog_category_id' => $category?->id, 'status' => 'published', 'published_at' => now()]);
    }
}
