<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLivrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('isbn');
            $table->string('resumo');
            $table->string('indice');
            $table->date('dtPublicacao');
            $table->string('titulo');
            $table->double('precovenda');

            $table->double('precocusto');
            $table->integer('estoque');

            /* chaves estrangeiras */
            $table->integer('editora_id')->unsigned();
            $table->foreign('editora_id')->references('id')->on('editoras');

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
        Schema::drop('livros');
    }
}
