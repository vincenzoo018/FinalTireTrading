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
        // Update the orders table
        Schema::table('orders', function (Blueprint $table) {
            // Drop the foreign key constraint on customer_id
            $table->dropForeign('orders_customer_id_foreign');

            // Drop the customer_id column
            $table->dropColumn('customer_id');

            // Add the user_id column
            $table->unsignedBigInteger('user_id')->after('order_id');

            // Add the cart_id column
            $table->unsignedBigInteger('cart_id')->after('user_id');

            // Add foreign keys
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('cart_id')->references('cart_id')->on('carts')->onDelete('cascade');
        });

        // Update the carts table
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['order_id']); // Drop the order_id foreign key
            $table->dropColumn('order_id'); // Remove the order_id column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert changes to the orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['cart_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn('cart_id');
            $table->dropColumn('user_id');
            $table->unsignedBigInteger('customer_id')->after('order_id');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
        });

        // Revert changes to the carts table
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable()->after('user_id');
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }
};
