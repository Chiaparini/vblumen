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


$app->get('api/book','BookController@index');
 
$app->get('api/book/{id}','BookController@getBook');
 
$app->post('api/book','BookController@saveBook');
 
$app->put('api/book/{id}','BookController@updateBook');
 
$app->delete('api/book/{id}','BookController@deleteBook');

/* ROTAS REFERENTES À EDITORA */

$app->get('api/editora', 'EditoraController@index');

$app->get('api/editora/{id}', 'EditoraController@getEditora');

$app->post('api/editora', 'EditoraController@saveEditora');
