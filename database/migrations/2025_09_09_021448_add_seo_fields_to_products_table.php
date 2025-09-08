<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image_alt')->nullable()->after('weight');
            $table->string('meta_title')->nullable()->after('sl');
            $table->string('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
            $table->string('meta_og_image')->nullable()->after('meta_keywords');
            $table->string('meta_og_alt')->nullable()->after('meta_og_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
              $table->dropColumn([
                'image_alt',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'meta_og_image',
                'meta_og_alt'
            ]);
        });
    }
};
