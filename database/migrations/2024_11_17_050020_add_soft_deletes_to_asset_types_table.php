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
        // Check if the column already exists before adding it
        if (!Schema::hasColumn('asset_types', 'deleted_at')) {
            Schema::table('asset_types', function (Blueprint $table) {
                $table->softDeletes(); // Adds the `deleted_at` column
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if the column exists before dropping it
        if (Schema::hasColumn('asset_types', 'deleted_at')) {
            Schema::table('asset_types', function (Blueprint $table) {
                $table->dropSoftDeletes(); // Removes the `deleted_at` column
            });
        }
    }
};
