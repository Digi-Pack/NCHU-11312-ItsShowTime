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
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['sort_order', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->unsignedSmallInteger('sort_order')->default(0)->comment('排序，數字越小越前面');
            $table->boolean('is_active')->default(true)->comment('是否啟用，1代表啟用，0代表不啟用');
        });
    }
};
