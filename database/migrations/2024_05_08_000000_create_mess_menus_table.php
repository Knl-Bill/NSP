<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mess_menus', function (Blueprint $table) {
            $table->id();
            $table->string('mess_hall');
            $table->date('menu_date');
            $table->text('breakfast');
            $table->text('lunch');
            $table->text('snacks');
            $table->text('dinner');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mess_menus');
    }
};