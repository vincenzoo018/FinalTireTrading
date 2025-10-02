<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('delivery_vehicles', function (Blueprint $table) {
            $table->id('vehicle_id');
            $table->unsignedBigInteger('delivery_id');
            $table->string('vehicle_name');
            $table->string('vehicle_plate_number');
            $table->date('date');
            $table->timestamps();

            $table->foreign('delivery_id')->references('delivery_id')->on('deliveries')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('delivery_vehicles');
    }
};
