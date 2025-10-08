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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('payment_method'); // Credit Card, PayPal, Bank Transfer, GCash, Cash
            $table->string('payment_status')->default('pending'); // pending, processing, completed, failed, refunded
            $table->string('transaction_id')->nullable(); // For external payment gateway reference
            $table->text('payment_details')->nullable(); // JSON data for card details, etc.
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();

            // Add indexes instead of foreign keys to avoid constraint issues
            $table->index('user_id');
            $table->index('order_id');
            $table->index('booking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
