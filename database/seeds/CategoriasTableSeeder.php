<?php

use Illuminate\Database\Seeder;

class CategoriasTableSeeder extends Seeder
{
    public function run()
    {

        DB::table('categorias')->insert([
        		'categoria' => 'Terror',
        	]);

        DB::table('categorias')->insert([
        		'categoria' => 'Fantasia',
        		'created_at' => date("Y-m-d H:i:s"),
        		'updated_at' => date("Y-m-d H:i:s"),
        	]);

        DB::table('categorias')->insert([
        		'categoria' => 'Crônicas',
        		'created_at' => date("Y-m-d H:i:s"),
        		'updated_at' => date("Y-m-d H:i:s"),
        	]);

        DB::table('categorias')->insert([
        		'categoria' => 'Ficção Científica',
        		'created_at' => date("Y-m-d H:i:s"),
        		'updated_at' => date("Y-m-d H:i:s"),
        	]);

        DB::table('categorias')->insert([
    		'categoria' => 'Didático',
    		'created_at' => date("Y-m-d H:i:s"),
    		'updated_at' => date("Y-m-d H:i:s"),
    	]);        

    	DB::table('categorias')->insert([
    		'categoria' => 'Literatura Nacional',
    		'created_at' => date("Y-m-d H:i:s"),
    		'updated_at' => date("Y-m-d H:i:s"),
    	]);

    	DB::table('categorias')->insert([
    		'categoria' => 'Literatura Internacional',
    		'created_at' => date("Y-m-d H:i:s"),
    		'updated_at' => date("Y-m-d H:i:s"),
    	]);

    	DB::table('categorias')->insert([
    		'categoria' => 'Romântico',
    		'created_at' => date("Y-m-d H:i:s"),
    		'updated_at' => date("Y-m-d H:i:s"),
    	]);

    	DB::table('categorias')->insert([
    		'categoria' => 'Religioso',
    		'created_at' => date("Y-m-d H:i:s"),
    		'updated_at' => date("Y-m-d H:i:s"),
    	]);


    }
}
?>