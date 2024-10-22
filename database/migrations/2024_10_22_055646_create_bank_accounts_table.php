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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->string('account_name', 100)->nullable();
            $table->string('account_number', 50);
            $table->string('bank_name', 100);
            $table->string('bank_branch_name', 100)->nullable();
            $table->decimal('initial_balance', 15, 2)->nullable();
            $table->decimal('current_balance', 15, 2)->nullable();
            $table->string('currency_code', 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
