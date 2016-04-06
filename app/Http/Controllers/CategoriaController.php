<?php
 
namespace App\Http\Controllers;
 
use App\Models\Categoria;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class CategoriaController extends Controller{
 
 
    public function index(){
 
        $categoria  = Categoria::all();
 
        return response()->json($categoria);
 
    }

}

?>