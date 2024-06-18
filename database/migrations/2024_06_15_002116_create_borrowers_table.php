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
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('borrower_name');
            $table->string('gender');
            $table->text('borrower_address');
            $table->text('borrower_phone');
            $table->string('borrower_occupation');
            $table->string('borrower_source_income');
            $table->decimal('borrower_income',10,2);
            $table->text('borrower_id_card');
            $table->string('borrower_bank_name')->nullable();
            $table->string('borrower_accountno')->nullable();
            $table->string('borrower_accountname')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowers');
    }
};
