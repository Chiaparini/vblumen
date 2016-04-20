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

class CarrinhoController extends Controller{
	//armazena as informações de livro e o estoque disponível
	protected $itens = array();

	//estoque calculado na função
	protected $estoque;

	/* Recebe o id do livro para anexá-lo ao carrinho */
	public function inserir($idLivro, $qtde){
		
		//Utilizado para testar a atualização de estoque pelo postman
		/*$item = [
			'id' => 6,
			'livro' => null,
			'estoque' => 3,
		];	

		array_push($this->itens, $item);*/

		$chave = null;

		//Verifica se o livro passado já está no carrinho
		foreach ($this->itens as $key => $val) {
    	   if ($val['id'] == $idLivro) {
        	   $chave = $key;
       		}
   		}


		//se o livro já estar contido calcula o novo estoque
		if(!is_null($chave)){
			$estoque = $this->itens[$chave]['estoque'] - $qtde;
			$item = ['estoque' => $estoque];
		}
		//senão faz a busca do livro no banco, calcula o estoque e prepara a inserção no array
		else{
			$livro = Livro::find($idLivro);

			$estoque = $livro->estoque - $qtde;

			$item = [
						'id' => $livro->id,
	        			'livro' => $livro,
	        			'estoque' => $estoque,
	        		];
        }

        //validação customizada para verificar se o estoque a ser registrado é maior que zero
		Validator::extend('indisponivel', function($estoque, $value, $item){
			if($value >= 0){
				return true;
			}
			else{
				return false;
			}

		});

		//mensagem de erro personalizada
		$messages = [
			'estoque.indisponivel' => 'Estoque insuficiente',
		];

		//realiza a validação
		$validator = Validator::make($item, ['estoque' => 'indisponivel'], $messages);
		 if($validator->fails()){
                return $validator->errors()->all();
        }
        else{
        	//se for no livro já contido no carrinho apenas muda seu estoque
        	if(!is_null($chave)){
        		$this->itens[$chave]['estoque'] = $estoque;
        	}
        	//senão adiciona um novo livro ao carrinho
        	else{
    			array_push($this->itens, $item);
        	}
        	
        	return response()->json($this->itens);
        }

	}

	
}