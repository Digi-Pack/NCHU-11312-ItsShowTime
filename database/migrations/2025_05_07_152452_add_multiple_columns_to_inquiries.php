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
            $table->string('address')->nullable()->comment('地址')->after('email');
            $table->unsignedInteger('status')->default(0)->comment('訂單狀態(0:未回覆，1:已回覆，2:取消)')->after('address');
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
