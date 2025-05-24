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
            // Drop the existing primary key constraint
            $table->dropPrimary('users_id_primary');

            // Change the id column to a string (CHAR(36) for UUID)
            $table->char('id', 36)->change();

            // Re-add the primary key constraint
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the primary key constraint
            $table->dropPrimary('users_id_primary');

            // Revert the id column to an auto-incrementing integer
            $table->id()->change();

            // Re-add the primary key (implicit with id())
        });
    }
};
