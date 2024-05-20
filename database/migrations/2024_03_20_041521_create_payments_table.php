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
            $table->integer('payment_to_id');
            $table->string('name');
            $table->integer('site_id');
            $table->string('site_name');
            $table->string('district')->nullable();
            $table->string('area')->nullable();

            $table->integer('account_id')->nullable();
            $table->integer('bank_name')->nullable();
            
            $table->string('site_bank_name')->nullable();
            $table->string('site_account_no')->nullable();
            $table->string('payment_method')->nullable();

            $table->decimal('net_payment_amount')->default(0);
            $table->decimal('others_amount')->default(0);
            $table->decimal('total')->default(0);
            $table->date('date')->nullable();
            $table->string('short_note')->nullable();
            $table->string('document')->nullable();

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
        Schema::dropIfExists('payments');
    }
};
