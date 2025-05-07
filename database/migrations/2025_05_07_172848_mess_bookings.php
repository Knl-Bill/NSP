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
        Schema::create('mess_bookings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('meal_date');
            $table->string('student_rollno');
            $table->string('meal_type');
            $table->string('booked_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mess_bookings');
    }
};
