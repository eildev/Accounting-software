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
        Schema::create('leave_application_details', function (Blueprint $table) {
            $table->id();
            $table->foreign('leave_application_id')->references('id')->on('leave_applications');
            $table->unsignedBigInteger('leave_application_id');
            $table->integer('total_day');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_application_details');
    }
};
