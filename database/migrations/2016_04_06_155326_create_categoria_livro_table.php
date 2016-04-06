<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriaLivroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_livro', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('livro_id')->unsigned();
            $table->integer('categoria_id')->unsigned();

            /* FOREIGN KEYS */
            $table->foreign('livro_id')->references('id')->on('livros');
            $table->foreign('categoria_id')->references('id')->on('categorias');

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
        Schema::drop('categoria_livro');
    }
}
