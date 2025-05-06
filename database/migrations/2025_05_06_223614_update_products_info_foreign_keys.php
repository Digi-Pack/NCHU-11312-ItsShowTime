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
        Schema::table('products_info', function (Blueprint $table) {
            $table->unsignedBigInteger('color_id')->nullable()->change();
            $table->foreign('color_id')
                ->references('id')
                ->on('colors')
                ->onDelete('set null');

            $table->unsignedBigInteger('type_id')->nullable()->change();
            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->onDelete('set null');

            $table->unsignedBigInteger('size_id')->nullable()->change();
            $table->foreign('size_id')
                ->references('id')
                ->on('sizes')
                ->onDelete('set null');

            $table->unsignedBigInteger('image_id')->nullable()->change();
            $table->foreign('image_id')
                ->references('id')
                ->on('images')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_info', function (Blueprint $table) {
            $table->dropForeign(['color_id']);
            $table->dropForeign(['type_id']);
            $table->dropForeign(['size_id']);
            $table->dropForeign(['image_id']);
        });
    }
};
