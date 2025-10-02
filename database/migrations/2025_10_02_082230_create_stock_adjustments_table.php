<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id('stock_adjustment_id');
            $table->unsignedBigInteger('stock_prod_id');
            $table->unsignedBigInteger('requested_by');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->dateTime('reviewed_date')->nullable();
            $table->string('reason')->nullable();
            $table->enum('adjustment_type', ['increase', 'decrease']);
            $table->integer('physical_count');
            $table->integer('system_count');
            $table->integer('adjust_count');
            $table->string('status');
            $table->timestamps();

            $table->foreign('stock_prod_id')->references('stock_prod_id')->on('stock_prods')->onDelete('cascade');
            $table->foreign('requested_by')->references('employee_id')->on('employees')->onDelete('cascade');
            $table->foreign('reviewed_by')->references('employee_id')->on('employees')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('stock_adjustments');
    }
};
