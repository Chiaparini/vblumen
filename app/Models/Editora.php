<?php 
namespace App\Models;

 use Illuminate\Database\Eloquent\Model;

 class Editora extends Model
 {
     
     protected $fillable = ['nome', 'cnpj', 'endereco', 'telefone'];

     public function livros(){
     	return $this->hasMany('App\Models\Livro');
     }
     
 }