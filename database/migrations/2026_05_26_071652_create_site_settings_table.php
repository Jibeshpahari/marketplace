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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Site Identity
            $table->string('site_name');
            $table->string('site_email');
            $table->string('site_phone')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('site_favicon')->nullable();
            $table->string('site_timezone')->default('UTC');
            $table->string('site_language')->default('en');
            $table->string('site_currency')->default('USD');
            $table->string('site_currency_symbol')->default('$');

            // Address
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();

            // Social Links
            $table->json('social_links')->nullable();

            // Pagination
            $table->enum('pagination_per_page', ['10', '20', '50', '100'])->default('20');
            $table->enum('admin_pagination_per_page', ['10', '20', '50', '100'])->default('20');

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('google_analytics_id')->nullable();
            $table->text('google_tag_manager')->nullable();
            $table->text('facebook_pixel')->nullable();

            // Maintenance
            $table->boolean('maintenance_mode')->default(false);
            $table->text('maintenance_message')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
