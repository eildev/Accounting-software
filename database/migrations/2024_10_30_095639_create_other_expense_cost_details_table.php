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
        Schema::create('other_expense_cost_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('other_expense_cost_id')->unsigned();
            $table->foreign('other_expense_cost_id')->references('id')->on('other_expense_costs')->onDelete('cascade');
            $table->date('other_expense_date');
            $table->string('other_expense_purpose');
            $table->decimal('other_expense_amount',15,2);
            $table->string('other_expense_assigned')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_expense_cost_details');
    }
};
