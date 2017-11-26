<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateType2typeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('node_types_node_types', function(Blueprint $table)
        {
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')
                ->on('node_types')->onDelete('cascade');

            $table->integer('child_id')->unsigned()->nullable();
            $table->foreign('child_id')->references('id')
                ->on('node_types')->onDelete('cascade');

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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('node_types');
        Schema::enableForeignKeyConstraints();
    }
}
