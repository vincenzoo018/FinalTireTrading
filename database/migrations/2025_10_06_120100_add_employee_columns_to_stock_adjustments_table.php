<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_adjustments', function (Blueprint $table) {
            if (!Schema::hasColumn('stock_adjustments', 'requested_by')) {
                $table->unsignedBigInteger('requested_by')->nullable()->after('status');
            }
            if (!Schema::hasColumn('stock_adjustments', 'reviewed_by')) {
                $table->unsignedBigInteger('reviewed_by')->nullable()->after('requested_by');
            }
            if (!Schema::hasColumn('stock_adjustments', 'admin_notes')) {
                $table->string('admin_notes')->nullable()->after('reviewed_by');
            }

            // Optionally add FKs if employees table exists
            if (Schema::hasTable('employees')) {
                try {
                    $table->foreign('requested_by')->references('employee_id')->on('employees')->nullOnDelete();
                } catch (\Throwable $e) {}
                try {
                    $table->foreign('reviewed_by')->references('employee_id')->on('employees')->nullOnDelete();
                } catch (\Throwable $e) {}
            }
        });
    }

    public function down(): void
    {
        Schema::table('stock_adjustments', function (Blueprint $table) {
            if (Schema::hasColumn('stock_adjustments', 'requested_by')) {
                $table->dropForeign(['requested_by']);
                $table->dropColumn('requested_by');
            }
            if (Schema::hasColumn('stock_adjustments', 'reviewed_by')) {
                $table->dropForeign(['reviewed_by']);
                $table->dropColumn('reviewed_by');
            }
            if (Schema::hasColumn('stock_adjustments', 'admin_notes')) {
                $table->dropColumn('admin_notes');
            }
        });
    }
};


