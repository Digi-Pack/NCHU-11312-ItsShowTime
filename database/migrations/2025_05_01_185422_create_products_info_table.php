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
        Schema::create('products_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('product_id')->nullable()->comment('商品id');
            $table->unsignedSmallInteger('size_id')->nullable()->comment('尺寸id');
            $table->unsignedSmallInteger('color_id')->nullable()->comment('顏色id');
            $table->unsignedSmallInteger('type_id')->nullable()->comment('類型id');
            $table->unsignedSmallInteger('image_id')->nullable()->comment('圖片id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_info');
    }
};
