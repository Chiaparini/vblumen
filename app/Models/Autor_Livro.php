<?php 
namespace App\Models;

 use Illuminate\Database\Eloquent\Model;

 class Autor_Livro extends Model
 {
     
     protected $fillable = ['livro_id', 'autor_id'];

     protected $table = 'autor_livro';
 }