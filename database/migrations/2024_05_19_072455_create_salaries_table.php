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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('name')->nullable();

            $table->integer('bank_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('payment_method')->nullable();

            $table->string('designation')->nullable();
            $table->decimal('salary')->default(0);
            $table->decimal('ta_da')->default(0);
            $table->decimal('mobile_bill')->default(0);
            $table->decimal('total')->default(0);
            $table->date('date')->nullable();

            $table->boolean('is_draft')->default(ENABLE);
            $table->integer('created_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
