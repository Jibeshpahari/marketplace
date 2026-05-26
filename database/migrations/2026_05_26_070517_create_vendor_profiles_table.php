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
        Schema::create('vendor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            // Store Info
            $table->string('store_name');
            $table->string('store_slug')->unique();
            $table->text('store_description')->nullable();
            $table->string('store_logo')->nullable();
            $table->string('store_banner')->nullable();

            // Contact
            $table->string('store_email')->nullable();
            $table->string('store_phone')->nullable();
            $table->string('store_address')->nullable();
            $table->string('store_city')->nullable();
            $table->string('store_country')->nullable();

            // Business
            $table->string('business_name')->nullable();
            $table->string('tax_number')->nullable();

            // Status
            $table->enum('status', ['pending', 'approved', 'rejected', 'suspended'])->default('pending');
            $table->enum('verification_status', ['unverified', 'verified'])->default('unverified');

            // Ratings (cached for performance)
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->unsignedInteger('total_reviews')->default(0);
            $table->unsignedInteger('total_sales')->default(0);

            // Commission (per vendor override)
            $table->decimal('commission_rate', 5, 2)->nullable(); // null = use global default

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_profiles');
    }
};
