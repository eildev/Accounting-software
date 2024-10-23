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
            $table->bigInteger('account_id');
            $table->string('transaction_id', 30)->nullable();
            $table->integer('invoice')->nullable();
            $table->enum('account_type', ['bank', 'cash']);
            $table->decimal('amount', 15, 2)->nullable();
            $table->date('transaction_date')->nullable();
            $table->enum('transaction_type', ['deposit', 'withdrawal', 'transfer', 'expense']);
            $table->text('description')->nullable();
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
