<?php
 
namespace App\Http\Controllers;
 
use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
 
class BookController extends Controller{
 
 
    public function index(){
 
        $books  = Book::all();
 
        return response()->json($books);
 
    }
 
    public function getBook($id){
 
        $book  = Book::find($id);
 
        return response()->json($book);
    }
 
    public function saveBook(Request $request){
 
        $book = Book::create($request->all());
        return response()->json($book);
 
    }
 
    public function deleteBook($id){
        $book  = Book::find($id);
 
        $book->delete();
 
        return response()->json('success');
    }
 
    public function updateBook(Request $request,$id){
        $book  = Book::find($id);
 
        $book->title = $request->input('titulo');
        $book->autor = $request->input('autor');
        $book->editora = $request->input('editora');
        $book->paginas = $request->input('paginas');
 
        $book->save();
 
        return response()->json($book);
    }
 
}