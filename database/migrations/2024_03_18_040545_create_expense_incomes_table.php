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
        Schema::create('expense_incomes', function (Blueprint $table) {
            $table->id();

            $table->integer('tender_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('accountable_id')->nullable();
            $table->string('accountable_type')->nullable();
            $table->string('ref')->nullable();
            $table->integer('labour_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->date('date');
            $table->enum('type', [EXPENSE, INCOME])->default(EXPENSE);
            $table->text('description')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('documents')->nullable();
            $table->decimal('total_amount', 19, 2)->default(0);
            $table->decimal('adjustment', 19, 2)->default(0);
            $table->decimal('grand_total', 19, 2)->default(0);
            $table->boolean('is_official')->default(DISABLE);
            $table->boolean('is_tender')->default(DISABLE);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_incomes');
    }
};
