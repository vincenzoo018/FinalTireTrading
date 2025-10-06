<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'approved_date')) {
                $table->dateTime('approved_date')->nullable()->after('status');
            }
            if (!Schema::hasColumn('orders', 'approved_note')) {
                $table->string('approved_note')->nullable()->after('approved_date');
            }
            if (!Schema::hasColumn('orders', 'rejected_reason')) {
                $table->string('rejected_reason')->nullable()->after('approved_note');
            }
            if (!Schema::hasColumn('orders', 'cancelled_reason')) {
                $table->string('cancelled_reason')->nullable()->after('rejected_reason');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'approved_date')) {
                $table->dropColumn('approved_date');
            }
            if (Schema::hasColumn('orders', 'approved_note')) {
                $table->dropColumn('approved_note');
            }
            if (Schema::hasColumn('orders', 'rejected_reason')) {
                $table->dropColumn('rejected_reason');
            }
            if (Schema::hasColumn('orders', 'cancelled_reason')) {
                $table->dropColumn('cancelled_reason');
            }
        });
    }
};


