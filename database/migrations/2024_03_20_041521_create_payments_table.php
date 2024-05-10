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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained()->onDelete('cascade');
            $table->string('receiver')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('check_no')->nullable();

            $table->integer('account_id');
            $table->integer('category_id');
            $table->string('payment_method');
            $table->decimal('total_amount',19,2)->default(0);
            $table->decimal('grand_total',19,2)->default(0);
            $table->date('date');
            $table->text('description')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('document')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
