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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('tender_id')->nullable();
            $table->string('ref')->nullable();
            $table->integer('user_id');
            $table->integer('account_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->date('date');
            $table->integer('trnxable_id');
            $table->string('trnxable_type');
            $table->enum('type', [CASH_IN, CASH_OUT]);
            $table->string('description')->nullable();
            $table->decimal('cash_in', 19, 2)->default(0);
            $table->decimal('cash_out', 19, 2)->default(0);
            $table->decimal('balance', 19, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
