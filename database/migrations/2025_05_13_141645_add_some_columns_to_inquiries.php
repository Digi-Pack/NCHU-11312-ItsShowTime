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
            $table->boolean('reply_mail_sent')->default(false)->after('mail_message')->comment('記錄已回覆狀態是否已發送郵件');
            $table->boolean('cancel_mail_sent')->default(false)->after('reply_mail_sent')->comment('記錄取消狀態是否發送郵件');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn('reply_mail_sent');
            $table->dropColumn('cancel_mail_sent');
        });
    }
};
