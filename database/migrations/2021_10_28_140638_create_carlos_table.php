<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarlosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 
     * asdasdasdasdasdasdsad
     * 
     * ddsfsdfdf
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('carlos', function (Blueprint $table) {
            $table->id();
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
        Schema::dropIfExists('carlos');
    }
}
