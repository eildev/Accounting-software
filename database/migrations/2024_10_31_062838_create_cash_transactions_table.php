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
        Schema::create('cash_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('cash_id')->unsigned();
            $table->foreign('cash_id')->references('id')->on('cashes');
            $table->date('transaction_date')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->enum('transaction_type', ['deposit', 'withdraw']);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('process_by')->unsigned();
            $table->foreign('process_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_transactions');
    }
};
