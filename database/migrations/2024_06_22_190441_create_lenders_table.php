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
        Schema::create('lenders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('lender_name');
            $table->string('gender');
            $table->text('lender_address');
            $table->text('lender_phone');
            $table->string('lender_occupation');
            $table->string('lender_source_income');
            $table->decimal('lender_income', 10);
            $table->string('lender_id_card_no', 16)->nullable();
            $table->text('lender_id_card');
            $table->string('lender_bank_name')->nullable();
            $table->string('lender_accountno')->nullable();
            $table->string('lender_accountname')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lenders');
    }
};
