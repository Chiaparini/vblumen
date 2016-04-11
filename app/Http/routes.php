<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Http\Request;

$app->get('/', function () use ($app) {
    return $app->version();
});

/* ROTAS REFERENTES À EDITORA */

$app->get('api/editora', 'EditoraController@index');

$app->get('api/editora/{id}', 'EditoraController@getEditora');

$app->post('api/editora', 'EditoraController@saveEditora');

/* ROTAS REFERENTES AO AUTOR */

$app->get('api/autor', 'AutorController@index');

$app->get('api/autor/{id}', 'AutorController@getAutor');

$app->post('api/autor', 'AutorController@saveAutor');

/* ROTAS REFERENTES AO LIVRO */

$app->post('api/livro', 'LivroController@saveLivro');

$app->get('api/livro', 'LivroController@index');

/* ROTA PARA SELEÇÃO DE CATEGORIAS */

$app->get('api/categoria', 'CategoriaController@index');