<?php
 
namespace App\Http\Controllers;
 
use App\Models\Editora;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 
 
class EditoraController extends Controller{
 
 
    public function index(){
 
        $editora  = Editora::all();
 
        return response()->json($editora);
 
    }
 
    public function getEditora($id){
 
        $editora  = Editora::find($id);
 
        return response()->json($editora);
    }
 
    public function saveEditora(Request $request){
 
        
            $messages = [
                'nome.required' => 'Campo nome obrigatório',
                'telefone.digits_between' => 'Número de telefone incorreto',
                'endereco.required' => 'Campo endereco obrigatório',
                'cnpj.regex' => 'CNPJ incorreto',
            ];

            /*$rules = $this->validate($request,[
                'nome' => 'required'
                ]);*/

            $validator = Validator::make($request->all(), [
                    'nome' => 'required',
                    'telefone' => 'digits_between:10,11',
                    'endereco' => 'required',
                    'cnpj' => 'regex:/[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}/'
                ], $messages);

            if($validator->fails()){
                return $validator->errors()->all();
            }else{
                $editora = Editora::create($request->all());
                return response()->json($editora);
            }
        

        
 
    }
}