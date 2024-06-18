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
        Schema::create('investors', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('investor_name');
            $table->string('gender');
            $table->text('investor_address');
            $table->text('investor_phone');
            $table->string('investor_occupation');
            $table->string('investor_source_income');
            $table->decimal('investor_income',10,2);
            $table->text('investor_id_card');
            $table->text('investor_text_card');
            $table->string('investor_bank_name')->nullable();
            $table->string('investor_accountno')->nullable();
            $table->string('investor_accountname')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investors');
    }
};
