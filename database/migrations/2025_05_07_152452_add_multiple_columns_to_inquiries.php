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
        Schema::table('inquiries', function (Blueprint $table) {
            $table->string('address')->comment('地址')->after('email');
            // $table->string('product')->comment('商品名稱');
            // $table->string('color')->comment('顏色');
            // $table->string('type')->comment('款式');
            // $table->string('size')->comment('尺寸');
            $table->unsignedInteger('status')->default(0)->comment('訂單狀態(0:未回覆，1:已回覆，2:取消)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn('address');
            // $table->dropColumn('product');
            // $table->dropColumn('color');
            // $table->dropColumn('type');
            // $table->dropColumn('size');
            $table->dropColumn('status');
        });
    }
};
