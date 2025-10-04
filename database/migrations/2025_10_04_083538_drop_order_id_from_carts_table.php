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
        // First: Check if column exists before dropping
        if (Schema::hasColumn('carts', 'order_id')) {
            // Try dropping the foreign key using raw SQL
            try {
                DB::statement('ALTER TABLE carts DROP FOREIGN KEY carts_order_id_foreign');
            } catch (\Exception $e) {
                // You can log the error if needed
                // Log::warning('Foreign key not found: ' . $e->getMessage());
            }

            // Then drop the column (safe now)
            Schema::table('carts', function (Blueprint $table) {
                $table->dropColumn('order_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable()->after('user_id');
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }
};