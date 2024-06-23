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
        Schema::create('lender_balance_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('lender_id');
            $table->decimal('amount', 15, 2);
            $table->string('status', 20)->default('Pending'); // Status bisa 'Pending', 'Approved', 'Rejected'
            $table->integer('settled_by')->nullable();
            $table->dateTime('settled_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lender_balance_transactions');
    }
};
