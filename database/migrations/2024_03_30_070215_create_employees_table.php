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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->string('full_name',200);
            $table->integer('department_id');
            $table->text('address')->nullable();
            $table->string('phone',20)->nullable();
            $table->string('email',200)->nullable();
            $table->string('nid',20)->nullable();
            $table->string('pic')->nullable();
            $table->string('designation')->nullable();
            $table->decimal('salary',15,2)->nullable();
            $table->string('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
