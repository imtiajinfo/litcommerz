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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('about');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->text('meta_keywords')->nullable()->after('meta_description');
            $table->string('meta_og_image')->nullable()->after('meta_keywords');
            $table->string('meta_og_alt')->nullable()->after('meta_og_image');
            
            $table->text('google_analytics')->nullable()->after('meta_og_alt');
            $table->text('google_tag_manager')->nullable()->after('google_analytics');
            $table->text('facebook_pixel')->nullable()->after('google_tag_manager');
            $table->string('google_site_verification')->nullable()->after('facebook_pixel');
            $table->string('bing_site_verification')->nullable()->after('google_site_verification');
            $table->string('yandex_site_verification')->nullable()->after('bing_site_verification');

            $table->string('favicon')->nullable()->after('yandex_site_verification');
            $table->string('default_twitter_card')->nullable()->after('favicon');
            $table->string('default_schema_type')->nullable()->after('default_twitter_card');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title',
                'meta_description',
                'meta_keywords',
                'meta_og_image',
                'meta_og_alt',
                'google_analytics',
                'google_tag_manager',
                'facebook_pixel',
                'google_site_verification',
                'bing_site_verification',
                'yandex_site_verification',
                'favicon',
                'default_twitter_card',
                'default_schema_type'
            ]);
        });
    }
};
