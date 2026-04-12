<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_color_variants', function (Blueprint $table) {
            $table->string('swatch_image_path', 2048)->nullable()->after('hex_color');
        });
    }

    public function down(): void
    {
        Schema::table('product_color_variants', function (Blueprint $table) {
            $table->dropColumn('swatch_image_path');
        });
    }
};
