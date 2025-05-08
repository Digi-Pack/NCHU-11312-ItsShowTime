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
        Schema::create('order_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inquiry_id')->comment('詢價清單id');
            $table->string('product')->comment('商品名稱');
            $table->string('color')->comment('顏色');
            $table->string('type')->comment('款式');
            $table->string('size')->comment('尺寸');
            $table->unsignedSmallInteger('quantity')->comment('數量');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_lists');
    }
};
