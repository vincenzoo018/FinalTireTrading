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
        Schema::table('users', function (Blueprint $table) {
            // Add username and password columns
            $table->string('username')->unique()->after('lname');
            $table->string('password')->after('username');

            // Add role_id foreign key
            $table->unsignedBigInteger('role_id')->default(3)->after('password'); // 3 = customer by default
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['role_id']);
            $table->dropColumn(['username', 'password', 'role_id']);
        });
    }
};