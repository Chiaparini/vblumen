<?php
 
namespace App\Http\Controllers;
 
use App\Models\Livro;
use App\Models\Categoria_Livro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 
class LivroController extends Controller{

	public function saveLivro(Request $request){
		$livro = Livro::create($request->all());
		$livro_id = $livro->id;

		/* Realiza a iteração para relacionar as 
		categorias selecionadas para este livro */
		foreach($request->input('categorias') as $cats){
			$cat = array();
			$cat['categoria_id'] = $cats;
			$cat['livro_id'] = $livro_id;
			$cat = Categoria_Livro::create($cat);
		}


        return response()->json($livro);
	}

}