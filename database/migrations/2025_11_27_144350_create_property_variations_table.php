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
        Schema::create('property_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->string('name'); // e.g., "150sqm - 3 Bedroom Terrace Duplex"
            $table->string('size')->nullable(); // e.g., "150sqm"
            $table->string('property_type')->nullable(); // e.g., "3 Bedroom Terrace Duplex"
            $table->integer('bedrooms')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2);
            $table->json('payment_plan')->nullable(); // Flexible payment plan structure
            $table->integer('order')->default(0); // For ordering variations
            $table->boolean('is_featured')->default(false); // Featured variation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_variations');
    }
};
