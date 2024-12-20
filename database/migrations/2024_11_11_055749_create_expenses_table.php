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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->date('expense_date')->nullable();
            $table->unsignedBigInteger('expense_category_id')->nullable();
            $table->foreign('expense_category_id')->references('id')->on('sub_ledgers');
            $table->string('purpose', 255);
            $table->decimal('amount' ,15, 2);
            $table->string('image')->nullable();
            $table->string('spender')->nullable();
            $table->integer('bank_account_id')->nullable();
            $table->integer('cash_account_id')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['processing', 'paid'])->default('processing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
