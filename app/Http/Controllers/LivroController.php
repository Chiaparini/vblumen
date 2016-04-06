<?php
 
namespace App\Http\Controllers;
 
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Categoria_Livro;
use App\Models\Autor_Livro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 
class LivroController extends Controller{

	public function saveLivro(Request $request){

		$messages = [
			'isbn.required' => 'Campo ISBN obrigatório',
			'isbn.numeric' => 'ISBN deve conter apenas números',
			'resumo.required' => 'Campo resumo obrigatório',
			'dtPublicacao.required' => 'Campo data de publicação obrigatório',
			'dtPublicacao.date_format' => 'Data de publicação incorreta',
			'titulo.required' => 'Campo título obrigatório',
			'precovenda.required' => 'Campo preço de venda obrigatório',
			'precovenda.numeric' => 'Preço de venda deve conter apenas números',
			'precocusto.required' => 'Campo preço de custo obrigatório',
			'precocusto.numeric' => 'Preço de custo deve conter apenas números',
			'estoque.required' => 'Campo estoque obrigatório',
			'estoque.integer' => 'Estoque deve ser um número inteiro',
			'editora_id.required' => 'Campo editora obrigatório',
			'categorias.required'  => 'Deve ter pelo menos uma categoria',
			'autores.required' => 'Deve ter pelo menos um autor',
		];

		$validator = Validator::make($request->all(),[
			'isbn' => 'required|numeric',
			'resumo' =>'required',
			'dtPublicacao' => 'required|date_format:Y-m-d',
			'titulo' => 'required',
			'precovenda' => 'required|numeric',
			'precocusto' => 'required|numeric',
			'estoque' => 'required|integer',
			'editora_id' => 'required',
			'categorias' => 'required',
			'autores' => 'required',

			], $messages);

		 if($validator->fails()){
                return $validator->errors()->all();
        }
        else{

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

			/* Realiza a iteração para relacionar os 
			autores selecionadas para este livro */
			foreach($request->input('autores') as $auts){
				$aut = array();
				$aut['autor_id'] = $auts;
				$aut['livro_id'] = $livro_id;
				$aut = Autor_Livro::create($aut);
			}
		}

        return response()->json($livro);
	}

}