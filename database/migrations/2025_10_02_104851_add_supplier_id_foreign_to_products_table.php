<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('products', function (Blueprint $table) {
            // Add supplier_id column
            $table->unsignedBigInteger('supplier_id')->nullable()->after('category_id');
            
            // Add foreign key constraint
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['supplier_id']);
            // Then drop the column
            $table->dropColumn('supplier_id');
        });
    }
};
