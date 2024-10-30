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
        Schema::create('recurring_expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('expanse_category_id')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('name', 99)->nullable();
            $table->date('start_date')->nullable();
            $table->enum('recurrence_period', ['monthly', 'quarterly', 'annually']);
            $table->date('next_due_date')->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_expenses');
    }
};
