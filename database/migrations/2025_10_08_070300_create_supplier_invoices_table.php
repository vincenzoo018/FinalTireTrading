<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_invoices', function (Blueprint $table) {
            $table->id('invoice_id');
            $table->string('invoice_number')->unique(); // Auto-generated: INV-2025-0001
            $table->unsignedBigInteger('transaction_id');
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['draft', 'issued', 'paid', 'cancelled'])->default('issued');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('transaction_id')
                  ->references('transaction_id')
                  ->on('supp_trans_orders')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_invoices');
    }
};
