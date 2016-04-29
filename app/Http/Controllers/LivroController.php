<?php
 
namespace App\Http\Controllers;
 
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Categoria_Livro;
use App\Models\Autor_Livro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 
use DB;
class LivroController extends Controller{


	public function index(){
		/* Resultado da consulta a ser exibida no JSON */		
		$result = array();

		$livros = Livro::all();

		for($i = 0; $i <  count($livros); $i++){
			$idLivro = $livros[$i]['id'];
			
			/* Seleciona um registro dos livros */
			$unidade = Livro::find($idLivro);

			/* Relaciona as informações correspondentes de autores, editora e categorias */
			$autor = $unidade->autores;
			$editora = $unidade->editora;
			$categoria = $unidade->categorias;

			array_push($result, $unidade);


		}

        return response()->json($result);
	}

	public function selectLivro($id){
		$livro = Livro::find($id);

		/* Relaciona as informa~ções correspondentes de autores, editora e categorias */
		$autor = $livro->autores;
		$editora = $livro->editora;
		$categoria = $livro->categorias;
		
		return response()->json($livro);
	}

	/*public function getLivros($titulo = null, $editora = null, $categoria = null, $autor = null){*/
		public function getLivros(Request $request){

		$result = array();

		/* MACGYVER STYLE */
		$livros = DB::table('livros')
								/* Seleciona apenas os campos a serem mostrados no resultado da pesquisa:
									id do livro (livro_id), preço de venda, nome do autor e o título do livro */
								->select(/*'autor_livro.livro_id', 'categoria_livro.livro_id',*/ 'livros.id', 'livros.titulo', 'livros.precovenda')
								->join('editoras', 'editoras.id', '=', 'livros.editora_id')
								->join('categoria_livro', 'categoria_livro.livro_id', '=', 'livros.id')
								->join('categorias', 'categoria_livro.categoria_id', '=', 'categorias.id')
								->join('autor_livro', 'autor_livro.livro_id', '=', 'livros.id')
								->join('autores', 'autor_livro.autor_id', '=', 'autores.id')
								->where('editoras.nome', 'like', "%".$request['editora']."%")
								->where('categorias.categoria', 'like', "%".$request['categoria']."%")
								->where('autores.nome', 'like', "%".$request['autor']."%")
								->where('titulo', 'like', "%".$request['titulo']."%")
								->distinct()
								->get();

		/* VAMOS CARPEADO!!!*/
		/* Agrupa os resultados de muitos autores em um mesmo livro */
		foreach ($livros as $livro) {
			$autor = DB::table('autores')
								->select('autores.nome as autor')
								->join('autor_livro', 'autor_livro.autor_id', '=', 'autores.id')
								->where('autor_livro.livro_id', '=', $livro->id)
								->get();

			array_push($result, $livro, $autor);
		}

		return response()->json($result);
	}

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
			'indice.required' => 'Campo índice obrigatório',
			'indice.url' => 'O campo índice deve indicar um endereço web válido'
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
			'indice' => 'required|url',

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