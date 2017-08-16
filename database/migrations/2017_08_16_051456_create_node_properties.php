<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodeProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('node_properties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('value')->nullable();
            $table->integer('node_id')->unsigned()->nullable();
            $table->foreign('node_id')->references('id')->on('nodes')->onDelete('cascade');
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
        Schema::dropIfExists('node_properties');
    }
}
