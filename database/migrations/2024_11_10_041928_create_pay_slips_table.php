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
        Schema::create('pay_slips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->date('pay_period_date');
            $table->decimal('total_gross_salary', 15, 2)->nullable();
            $table->decimal('total_deductions', 15, 2)->nullable();
            $table->decimal('total_net_salary', 15, 2)->nullable();
            $table->decimal('total_employee_bonus', 15, 2)->nullable();
            $table->decimal('total_convenience_amount', 15, 2)->nullable();
            $table->string('status',20)->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_slips');
    }
};
