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
            // Drop the foreign key constraint on order_id if it exists
            $table->dropForeign(['order_id']);

            // Drop the order_id column
            $table->dropColumn('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Re-add the order_id column
            $table->unsignedBigInteger('order_id')->nullable()->after('user_id');

            // Re-add the foreign key constraint
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }
};
