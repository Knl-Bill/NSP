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
        //
        Schema::create('guestentry', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phoneno');
            $table->string('checkin_date');
            $table->string('checkin_time');
            $table->string('checkin_gate');
            $table->string('checkout_date')->nullable();
            $table->string('checkout_time')->nullable();
            $table->string('checkout_gate')->nullable();
            $table->string('email_Id')->nullable();
            $table->string('student_rollno')->nullable();
            $table->string('stay_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('guestentry');
    }
};
