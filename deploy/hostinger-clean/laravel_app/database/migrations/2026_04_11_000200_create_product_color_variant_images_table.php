<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_color_variant_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_color_variant_id')->constrained()->cascadeOnDelete();
            $table->string('image_path', 2048);
            $table->string('alt_text')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_color_variant_images');
    }
};
