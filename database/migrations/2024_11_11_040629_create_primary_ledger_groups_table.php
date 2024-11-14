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
        Schema::create('primary_ledger_groups', function (Blueprint $table) {
            $table->id(); // INT AUTO_INCREMENT PRIMARY KEY,
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('general_ledger_id')->nullable();
            $table->foreign('general_ledger_id')->references('id')->on('general_ledgers');
            $table->string('group_name', 50);  // NOT NULL -- E.g., 'Assets', 'Liabilities', 'Income', 'Expenses'
            $table->string('slug', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('primary_ledger_groups');
    }
};
