<?php 
namespace App\Models;

 use Illuminate\Database\Eloquent\Model;

 class Categoria_Livro extends Model
 {
     
     protected $fillable = ['livro_id', 'categoria_id'];

     protected $table = 'categoria_livro';
 }