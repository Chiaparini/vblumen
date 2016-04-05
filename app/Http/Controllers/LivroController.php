<?php
 
namespace App\Http\Controllers;
 
use App\Models\Livro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 
class LivroController extends Controller{

	public function saveLivro(Request $request){
		$livro = Livro::create($request->all());
        return response()->json($livro);
	}

}