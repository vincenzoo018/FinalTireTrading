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
        // ✅ Step 1: Drop foreign key and column 'order_id' from 'carts' table
        if (Schema::hasColumn('carts', 'order_id')) {
            // Use raw SQL to drop foreign key safely
            try {
                DB::statement('ALTER TABLE carts DROP FOREIGN KEY carts_order_id_foreign');
            } catch (\Exception $e) {
                // Foreign key might not exist; ignore or log
            }

            // Now drop the column in a separate Schema call
            Schema::table('carts', function (Blueprint $table) {
                $table->dropColumn('order_id');
            });
        }

        // ✅ Step 2: Add 'cart_id' foreign key to 'orders' table
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'cart_id')) {
                $table->unsignedBigInteger('cart_id')->after('order_id');
                $table->foreign('cart_id')->references('cart_id')->on('carts')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ❌ Step 1: Drop 'cart_id' from 'orders' table
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'cart_id')) {
                $table->dropForeign(['cart_id']);
                $table->dropColumn('cart_id');
            }
        });

        // ❌ Step 2: Re-add 'order_id' to 'carts' table
        if (!Schema::hasColumn('carts', 'order_id')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->unsignedBigInteger('order_id')->nullable()->after('user_id');
                $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            });
        }
    }
};