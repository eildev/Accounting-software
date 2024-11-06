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
        Schema::create('employee_bonuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->enum('bonus_type', ['performance', 'festival', 'other']);
            $table->decimal('bonus_amount', 12, 2);
            $table->date('bonus_date');
            $table->string('bonus_reason', 255)->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->string('status',20)->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_bonuses');
    }
};
