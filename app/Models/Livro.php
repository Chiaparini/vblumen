<?php
namespace App\Models;

 use Illuminate\Database\Eloquent\Model;

 class Livro extends Model
 {

     protected $fillable = ['isbn', 'resumo', 'indice', 'dtPublicacao',
     	'titulo', 'precovenda', 'precocusto', 'estoque', 'editora_id', 'paginas', 'formato'];

     protected $table = 'livros';

     public function editora(){
     	return $this->belongsTo('App\Models\Editora');
     }

     public function categorias(){
     	return $this->belongsToMany('App\Models\Categoria');
     }

     public function autores(){
     	return $this->belongsToMany('App\Models\Autor');
     }

}
