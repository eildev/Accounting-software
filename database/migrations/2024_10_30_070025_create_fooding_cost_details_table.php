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
        Schema::create('fooding_cost_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('fooding_cost_id')->unsigned();
            $table->foreign('fooding_cost_id')->references('id')->on('fooding_costs')->onDelete('cascade');
            $table->date('fooding_date');
            $table->string('fooding_place_of_visit')->nullable();
            $table->string('fooding_purpose')->nullable();
            $table->string('fooding_time');
            $table->decimal('fooding_amount',15,2);
            $table->string('fooding_assigned')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fooding_cost_details');
    }
};
