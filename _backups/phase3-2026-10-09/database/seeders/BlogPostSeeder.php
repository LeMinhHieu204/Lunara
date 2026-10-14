<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['title' => 'The quiet power of a considered wardrobe', 'slug' => 'quiet-power-considered-wardrobe', 'excerpt' => 'A few good pieces can create more ease in the everyday.', 'body' => "Getting dressed should feel like a small act of clarity. Start with pieces that work together, move with you and earn their place through repeat wear.", 'featured_image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1200&q=86'],
            ['title' => 'How to make neutrals feel personal', 'slug' => 'how-to-make-neutrals-feel-personal', 'excerpt' => 'Texture, proportion and the details that make a quiet palette your own.', 'body' => "Neutrals are never one-note. Mix texture, soften structure and let one thoughtful detail carry the story.", 'featured_image' => 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=1200&q=86'],
        ] as $post) BlogPost::updateOrCreate(['slug' => $post['slug']], $post + ['status' => 'published', 'published_at' => now()]);
    }
}
