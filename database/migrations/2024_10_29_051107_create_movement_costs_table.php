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
        Schema::create('movement_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->date('movement_date');
            $table->text('movement_from');
            $table->text('movement_to');
            $table->string('mode_of_transport');
            $table->string('movement_purpose')->nullable();;
            $table->decimal('movement_amount',15,2);
            $table->string('movement_assigned')->nullable();
            $table->string('movement_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_costs');
    }
};
