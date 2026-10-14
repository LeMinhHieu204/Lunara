<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('brand_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
        });
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->foreignId('blog_category_id')->nullable()->after('author_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', fn (Blueprint $table) => $table->dropConstrainedForeignId('blog_category_id'));
        Schema::table('products', fn (Blueprint $table) => $table->dropConstrainedForeignId('brand_id'));
    }
};
