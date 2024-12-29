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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->date('sale_date')->nullable();
            $table->integer('sale_by')->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('total', 12, 2)->default(0); //total product price
            $table->string('discount')->nullable(); //user input
            $table->decimal('grand_total', 12, 2)->nullable();
            $table->decimal('paid', 12, 2)->default(0); //total paid
            $table->decimal('due', 12, 2)->default(0); // updated due
            $table->decimal('returned', 12, 2)->default(0); //returned amount
            $table->decimal('total_purchase_cost', 12, 2)->nullable(); //updated after return
            $table->decimal('total_profit', 10, 2)->default(0);
            $table->text('note')->nullable();
            $table->enum('status', ['processing', 'completed'])->default('processing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
