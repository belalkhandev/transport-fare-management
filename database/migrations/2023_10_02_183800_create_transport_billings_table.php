<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('academic_plan_id')->nullable()->constrained('academic_plans')->cascadeOnDelete();
            $table->integer('month')->nullable();
            $table->string('year')->nullable();
            $table->date('due_date')->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->double('due_amount', 8, 2)->nullable();
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transport_billings');
    }
};
