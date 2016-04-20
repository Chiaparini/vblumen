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


            if(!is_null($autor['dtFal'])){
                $data = explode("-", $autor['dtFal']);
                $autor['dtFal'] = $data[2] . "-" . $data[1] . "-" . $data[0];
            }
        }
        
        return response()->json($autores);
 
    }
 
    public function getAutor($id){
 
        $autor  = Autor::find($id);
        
                
        $data = explode("-", $autor['dtNasc']);
        $autor['dtNasc'] = $data[2] . "-" . $data[1] . "-" . $data[0];

        if(!is_null($autor['dtFal'])){
            $data = explode("-", $autor['dtFal']);
            $autor['dtFal'] = $data[2] . "-" . $data[1] . "-" . $data[0];
        }

        return response()->json($autor);
    }
 
    public function saveAutor(Request $request){
        // "validação" de data de nascimento anterior a atual...
        //Go Roach!!
        if($request['dtNasc'] >= date("Y-m-d")){
            $request['dtNasc'] = null;
        }

        // "validação" de data de nascimento maior que a de falecimento
        if(!is_null($request['dtFal'])){
            if($request['dtNasc'] > $request['dtFal']){
                $request['dtNasc'] = null;
            }
        }

        /*return response()->json($request['dtNasc']);*/

        $messages = [
                'nome.required' => 'Campo nome obrigatório',
                'dtNasc.date_format' => 'Data de nascimento incorreta',
                
        ];

        if(!is_null($request['dtFal']) || !is_null($request['localFal'])){

            $messages = [
                'nome.required' => 'Campo nome obrigatório',
                'dtNasc.required' => 'Data de nascimento inválida',
                'dtNasc.date_format' => 'Data de nascimento incorreta',
                'dtFal.required_with' => 'A data da morte também deve ser preenchida',
                'dtFal.date_format' => 'Data de falecimento incorreta',
                'localFal.required_with' => 'O local da morte também deve ser preenchido',
                'localNasc.required'  => 'Campo local de nascimento obrigatório',
                'biografia.required'  => 'Campo biografia obrigatório',
                'dtNasc.dtMenorAtual' => 'Data de nascimento não pode ser menor que a atual',
            ];

            $validator = Validator::make($request->all(), [
                'nome' => 'required',
                'dtNasc' => 'required|date_format:Y-m-d',
                'dtFal' => 'required_with:localFal|date_format:Y-m-d',
                'localFal' => 'required_with:dtFal',
                'localNasc' => 'required',
                'biografia' => 'required',

            ], $messages);

        }
        else{

            $messages = [
                'nome.required' => 'Campo nome obrigatório',
                'dtNasc.required' => 'Data de nascimento inválida',
                'dtNasc.date_format' => 'Data de nascimento incorreta',
                'localNasc.required'  => 'Campo local de nascimento obrigatório',
                'biografia.required'  => 'Campo biografia obrigatório',
            ];
             
            $validator = Validator::make($request->all(), [
                'nome' => 'required',
                'dtNasc' => 'required|date_format:Y-m-d',
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

            if(!is_null($request['dtFal']) || !is_null($request['localFal'])){
                $data = explode("-", $autor['dtFal']);
                $autor['dtFal'] = $data[2] . "-" . $data[1] . "-" . $data[0];
            }

            return response()->json($autor);
            
        }

        
 
    }
}