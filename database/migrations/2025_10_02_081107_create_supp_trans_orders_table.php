<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('supp_trans_orders', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->string('reference_num');
            $table->date('order_date');
            $table->date('delivery_date')->nullable();
            $table->decimal('delivery_fee', 10, 2)->default(0.00);
            $table->boolean('delivery_received')->default(false);
            $table->date('estimated_date')->nullable();
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('sub_total', 10, 2)->default(0.00);
            $table->decimal('overall_total', 10, 2)->default(0.00);
            $table->unsignedBigInteger('supplier_id');
            $table->timestamps();

            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('supp_trans_orders');
    }
};
