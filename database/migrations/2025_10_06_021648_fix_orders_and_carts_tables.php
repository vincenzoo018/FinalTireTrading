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
        // Add user_id to orders table if it doesn't exist
        if (!Schema::hasColumn('orders', 'user_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->after('order_id');
                $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            });
        }

        // Add status to orders table if it doesn't exist
        if (!Schema::hasColumn('orders', 'status')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('status')->default('pending')->after('order_date');
            });
        }

        // Update carts table to use user_id instead of customer_id
        if (Schema::hasColumn('carts', 'customer_id')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->dropForeign(['customer_id']);
                $table->dropColumn('customer_id');
            });
        }

        if (!Schema::hasColumn('carts', 'user_id')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->after('product_id');
                $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            });
        }

        // Add quantity to carts table if it doesn't exist
        if (!Schema::hasColumn('carts', 'quantity')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->integer('quantity')->default(1)->after('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove user_id from orders table
        if (Schema::hasColumn('orders', 'user_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }

        // Remove status from orders table
        if (Schema::hasColumn('orders', 'status')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }

        // Revert carts table to use customer_id
        if (Schema::hasColumn('carts', 'user_id')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }

        if (!Schema::hasColumn('carts', 'customer_id')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->unsignedBigInteger('customer_id')->after('product_id');
                $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            });
        }

        // Remove quantity from carts table
        if (Schema::hasColumn('carts', 'quantity')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->dropColumn('quantity');
            });
        }
    }
};
