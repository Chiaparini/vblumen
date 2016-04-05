<?php 
namespace App\Models;

 use Illuminate\Database\Eloquent\Model;

 class Categoria extends Model
 {
     
     protected $fillable = ['categoria'];

     protected $table = 'categorias';

     public function livro(){
     	return $this->belongsTo('App\Models\Livro');
     }

     

}