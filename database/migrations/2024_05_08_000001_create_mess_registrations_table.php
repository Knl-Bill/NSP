<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mess_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('rollno');
            $table->string('mess_hall');
            $table->date('registration_date');
            $table->boolean('breakfast')->default(false);
            $table->boolean('lunch')->default(false);
            $table->boolean('snacks')->default(false); 
            $table->boolean('dinner')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mess_registrations');
    }
};