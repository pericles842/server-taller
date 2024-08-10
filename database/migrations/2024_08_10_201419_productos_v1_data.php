<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProductosV1Data extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // DATA TABLA LISTA DE PRECIOS
        DB::table('price_list')->insert([
            "name" => "Lista general",
            "description" => "Lista de precios generales",
            "user_id" => 1,
            "fecha_inicio" => date('Y-m-d'),
            "fecha_fin" => "2024-08-31"
        ]);

        // DATA TABLA CATEGORÍA
        DB::table('category')->insert([
            "name" => "Ropa",
            "father_category_id" => null,
            "user_id" => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('price_list')->truncate();
        DB::table('category')->truncate();
    }
}
