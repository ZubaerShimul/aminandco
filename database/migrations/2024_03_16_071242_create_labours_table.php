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
        Schema::create('labours', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('tender_id')->nullable();
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('joining_date')->nullable();
            $table->decimal('salary',19,2)->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labours');
    }
};
