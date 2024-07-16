<?php

use App\Enums\BloodGroup;
use App\Enums\EducationLevel;
use App\Enums\GenderEnum;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->enum('education_level', EducationLevel::values())->nullable();
            $table->string('name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('contact_no');
            $table->string('email')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', GenderEnum::values())->nullable();
            $table->enum('blood_group', BloodGroup::values())->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('students');
    }
};
