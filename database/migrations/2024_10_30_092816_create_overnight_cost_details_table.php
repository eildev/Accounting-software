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
        Schema::create('overnight_cost_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');;
            $table->unsignedBigInteger('overnight_cost_id')->unsigned();
            $table->foreign('overnight_cost_id')->references('id')->on('overnight_costs');
            $table->date('overnight_date');
            $table->string('overnight_place_of_visit');
            $table->string('overnight_purpose')->nullable();
            $table->string('overnight_stay_period');
            $table->decimal('overnight_amount',15,2);
            $table->string('overnight_assigned')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overnight_cost_details');
    }
};
