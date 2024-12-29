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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id')->unsigned();
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->integer('product_id');
            $table->decimal('price', 10, 2);
            $table->integer('discount')->nullable();
            $table->integer('quantity');
            $table->decimal('sub_total', 12, 2);
            $table->decimal('purchase_cost', 12, 2)->nullable();
            $table->decimal('profit', 12, 2)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
