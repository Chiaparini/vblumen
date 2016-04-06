<?php 
namespace App\Models;

 use Illuminate\Database\Eloquent\Model;

 class Autor extends Model
 {
     
     protected $fillable = ['nome', 'dtNasc', 'localNasc', 'dtFal', 'localFal', 'biografia'];

     protected $table = 'autores';

     public function livros(){
     	return $this->belongsToMany('App\Models\Livro');
     }

}