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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('source_id')->nullable();  // Reference to the originating record
            $table->string('source_type')->nullable();  // e.g., 'payroll', 'expense', 'vendor_payment'
            $table->date('transaction_date')->nullable();  // e.g., 'payroll', 'expense', 'vendor_payment'
            $table->unsignedBigInteger('bank_account_id')->nullable();  // For bank-based transactions
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts');
            $table->unsignedBigInteger('cash_account_id')->nullable();  // For cash-based transactions
            $table->foreign('cash_account_id')->references('id')->on('cashes');
            $table->decimal('amount', 15, 2);
            $table->enum('transaction_type', ['credit', 'debit', 'bl_transfer']);  // Credit = incoming, Debit = outgoing
            $table->text('description')->nullable();
            $table->string('transaction_id', 30)->nullable();
            $table->integer('transaction_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};