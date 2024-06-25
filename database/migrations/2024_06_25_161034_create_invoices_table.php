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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('inv_no');
            $table->string('loan_no');
            $table->integer('borrower_id');
            $table->decimal('outstanding', 12, 3)->nullable();
            $table->decimal('current_outstanding', 12, 3)->nullable();
            $table->decimal('penalty', 12, 3)->nullable();
            $table->enum('status', ['paid', 'not paid'])->default('paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
