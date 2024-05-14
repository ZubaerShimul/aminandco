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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation');
            $table->string('address')->nullable();
            $table->string('NID')->nullable();
            $table->string('contact_no');
            $table->string('blood_group')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('resigning_date')->nullable();
            $table->boolean('is_resigned')->default(DISABLE);
            $table->decimal('basic_salary',19,2)->default(0);
            $table->string('image')->nullable();

            $table->integer('created_by');
            $table->boolean('is_draft')->default(ENABLE);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
