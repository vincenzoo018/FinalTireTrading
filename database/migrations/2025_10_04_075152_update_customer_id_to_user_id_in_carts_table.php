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
        Schema::table('carts', function (Blueprint $table) {
            // Drop the foreign key and column for customer_id
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');

            // Add the user_id column and foreign key
            $table->unsignedBigInteger('user_id')->after('product_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Drop the foreign key and column for user_id
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Re-add the customer_id column and foreign key
            $table->unsignedBigInteger('customer_id')->after('product_id');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
        });
    }
};
