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
        Schema::create('student_academic_plan', function (Blueprint $table) {
            $table->unsignedBigInteger('academic_plan_id')->unsigned();
            $table->unsignedBigInteger('student_id')->unsigned();

            $table->foreign('academic_plan_id')->references('id')->on('academic_plans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['academic_plan_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_academic_plan');
    }
};
