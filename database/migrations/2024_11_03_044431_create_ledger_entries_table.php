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
        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->id(); //Unique identifier for each ledger entry
            $table->unsignedBigInteger('branch_id')->unsigned(); //Foreign key linking back to the Branch table.n
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('transaction_id')->unsigned(); //Foreign key linking back to the transactions table.n
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->unsignedBigInteger('group_id')->unsigned(); // Foreign key linking to primary_ledger_groups table.n.
            $table->foreign('group_id')->references('id')->on('primary_ledger_groups');
            $table->unsignedBigInteger('account_id')->unsigned(); // Foreign key linking to the ledger_accounts table.n
            $table->foreign('account_id')->references('id')->on('ledger_accounts');
            $table->unsignedBigInteger('sub_ledger_id')->unsigned(); // Foreign key linking to the sub_ledgers table.n
            $table->foreign('sub_ledger_id')->references('id')->on('sub_ledgers');
            $table->decimal('entry_amount', 15, 2)->nullable();
            $table->date('transaction_date')->nullable();
            $table->unsignedBigInteger('transaction_by')->nullable(); // Foreign key linking to the users table.n
            $table->foreign('transaction_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_entries');
    }
};
