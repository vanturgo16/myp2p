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
        Schema::create('loans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('loan_no')->nullable();
            $table->unsignedBigInteger('borrower_id');
            $table->integer('loan_product_id');
            $table->decimal('loan_amount', 10);
            $table->text('loan_purpose');
            $table->decimal('platform', 5)->nullable();
            $table->decimal('platform_amount', 12, 3)->nullable();
            $table->decimal('lender', 5, 3)->nullable();
            $table->decimal('lender_amount', 12, 3)->nullable();
            $table->integer('duration_months');
            $table->enum('status', ['pending', 'approval', 'approved', 'rejected', 'funded', 'disbursed', 'paid'])->default('pending');
            $table->decimal('disburst_amount', 12, 3)->nullable();
            $table->dateTime('disburst_date')->nullable();
            $table->decimal('total_pay', 12, 3)->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
