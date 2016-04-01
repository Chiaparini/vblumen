<?php
 
namespace App\Http\Controllers;
 
use App\Models\Autor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

 
class AutorController extends Controller{
 
 
    public function index(){
 
        $autores  = Autor::all();

        foreach($autores as $autor){
            $data = explode("-", $autor['dtNasc']);
            $autor['dtNasc'] = $data[2] . "-" . $data[1] . "-" . $data[0];

            $data = explode("-", $autor['dtFal']);
            $autor['dtFal'] = $data[2] . "-" . $data[1] . "-" . $data[0];
        }
        
        return response()->json($autores);
 
    }
 
    public function getAutor($id){
 
        $autor  = Autor::find($id);
        
                
        $data = explode("-", $autor['dtNasc']);
        $autor['dtNasc'] = $data[2] . "-" . $data[1] . "-" . $data[0];

        $data = explode("-", $autor['dtFal']);
        $autor['dtFal'] = $data[2] . "-" . $data[1] . "-" . $data[0];


        return response()->json($autor);
    }
 
    public function saveAutor(Request $request){
 
        

        $messages = [
                'nome.required' => 'Campo nome obrigatório',
                'dtNasc.date_format' => 'Data de nascimento incorreta',
                
        ];

        if(!is_null($request['dtFal']) || !is_null($request['localFal'])){

            $messages = [
                'nome.required' => 'Campo nome obrigatório',
                'dtNasc.date_format' => 'Data de nascimento incorreta',
                'dtFal.required_with' => 'O local da morte também deve ser preenchido',
                'dtFal.date_format' => 'Data de falecimento incorreta',
                'localFal.required_with' => 'A data da morte também deve ser preenchida',
                'localNasc.required'  => 'Campo local de nascimento obrigatório',
                'biografia.required'  => 'Campo biografia obrigatório',
            ];

            $validator = Validator::make($request->all(), [
                'nome' => 'required',
                'dtNasc' => 'date_format:Y-m-d',
                'dtFal' => 'date_format:Y-m-d|required_with:localFal',
                'localFal' => 'required_with:dtFal',
                'localNasc' => 'required',
                'biografia' => 'required',

            ], $messages);

        }
        else{

            $messages = [
                'nome.required' => 'Campo nome obrigatório',
                'dtNasc.date_format' => 'Data de nascimento incorreta',
                'localNasc.required'  => 'Campo local de nascimento obrigatório',
                'biografia.required'  => 'Campo biografia obrigatório',
            ];
             
            $validator = Validator::make($request->all(), [
                'nome' => 'required',
                'dtNasc' => 'date_format:Y-m-d',
                'localNasc' => 'required',
                'biografia' => 'required',
                                

            ], $messages);
  
        }

        
        if($validator->fails()){
            return $validator->errors()->all();
        }else{
            $autor = Autor::create($request->all());

            $data = explode("-", $autor['dtNasc']);
            $autor['dtNasc'] = $data[2] . "-" . $data[1] . "-" . $data[0];

            $data = explode("-", $autor['dtFal']);
            $autor['dtFal'] = $data[2] . "-" . $data[1] . "-" . $data[0];

            return response()->json($autor);
        }

        
 
    }
}