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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('name');
            $table->string('type');
            
            $table->integer('account_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('payment_method')->nullable();

            $table->integer('site_id')->nullable();
            $table->string('site_name')->nullable();
            $table->string('division')->nullable();
            $table->string('area')->nullable();
            
            $table->text('note')->nullable();
            $table->decimal('amount')->default(0);
            $table->string('document')->nullable();
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
        Schema::dropIfExists('expenses');
    }
};
