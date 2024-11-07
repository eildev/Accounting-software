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
        Schema::create('sub_ledgers', function (Blueprint $table) {
            $table->id(); // Primary key for each sub-ledger entry.
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('account_id')->unsigned(); //  Foreign key linking each sub-ledger to a ledger account.
            $table->foreign('account_id')->references('id')->on('ledger_accounts');
            $table->string('sub_ledger_name', 100)->nullable(); // Name for specific sub-ledger (e.g., Cash in Hand, Bank Savings).
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_ledgers');
    }
};
