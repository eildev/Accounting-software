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
        Schema::create('ledger_accounts', function (Blueprint $table) {
            $table->id(); // Unique identifier for each ledger account
            $table->unsignedBigInteger('group_id')->unsigned(); // Foreign key to link each account to a primary ledger group.
            $table->foreign('group_id')->references('id')->on('primary_ledger_groups');
            $table->string('account_name', 100)->nullable(); // Name of the specific ledger account (e.g., Cash, Accounts Payable).
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_accounts');
    }
};
