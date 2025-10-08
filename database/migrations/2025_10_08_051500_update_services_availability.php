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
        // Add is_available column if it doesn't exist
        if (!Schema::hasColumn('services', 'is_available')) {
            Schema::table('services', function (Blueprint $table) {
                $table->boolean('is_available')->default(true)->after('employee_id');
            });
        }

        // Update all existing services to be available
        DB::table('services')->update(['is_available' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optional: Remove the column
        if (Schema::hasColumn('services', 'is_available')) {
            Schema::table('services', function (Blueprint $table) {
                $table->dropColumn('is_available');
            });
        }
    }
};
