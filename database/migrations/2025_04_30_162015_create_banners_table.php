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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('作品名稱');
            $table->text('img_name')->comment('圖片名稱');
            $table->text('img_path')->comment('圖片路徑');
            $table->unsignedSmallInteger('sort_order')->default(0)->comment('排序，數字越小越前面');
            $table->boolean('is_active')->default(true)->comment('是否啟用，1代表啟用，0代表不啟用');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
