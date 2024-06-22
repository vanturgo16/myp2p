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
        Schema::create('loan_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->decimal('platform',3,3);
            $table->decimal('lender',3,3);
            $table->decimal('penalty',3,3);
            $table->decimal('min_loan_amount',13,2);
            $table->decimal('max_loan_amount',13,2);
            $table->integer('tenor');
            $table->enum('tenor_type', ['days', 'months']);
            $table->enum('type', ['1', '2'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_products');
    }
};
