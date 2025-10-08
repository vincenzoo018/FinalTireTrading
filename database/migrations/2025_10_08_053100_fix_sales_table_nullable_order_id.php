<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Make order_id nullable to allow booking sales without orders
        Schema::table('sales', function (Blueprint $table) {
            // Drop the existing foreign key first
            $table->dropForeign(['order_id']);
        });

        // Change the column to nullable
        DB::statement('ALTER TABLE sales MODIFY order_id BIGINT UNSIGNED NULL');

        // Re-add the foreign key
        Schema::table('sales', function (Blueprint $table) {
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to NOT NULL if needed
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
        });
        
        DB::statement('ALTER TABLE sales MODIFY order_id BIGINT UNSIGNED NOT NULL');
        
        Schema::table('sales', function (Blueprint $table) {
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }
};
