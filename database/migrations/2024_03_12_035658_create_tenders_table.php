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
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            
            $table->string('tender_no')->nullable();
            $table->string('name');            
            $table->integer('account_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->string("district_name")->nullable();
            
            $table->string('working_time')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('due_day')->nullable();

            $table->decimal('budget',19,2)->default(0);
            $table->decimal('opening_amount',19,2)->default(0);
            $table->decimal('total_paid',19,2)->default(0);
            $table->decimal('due',19,2)->default(0);

            $table->tinyInteger('status')->default(TENDER_STATUS_PENDING);
            $table->string('payment_status')->default("Unpaid");
            $table->boolean('is_completed')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
