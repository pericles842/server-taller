<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProductosV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //------------------------------------------------------------------------------------
        //*TABLA LISTA DE PRECIOS
        //?LISTAS DE PRECIOS
        //------------------------------------------------------------------------------------
        Schema::create('price_list', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500)->nullable(false);
            $table->string('description', 800)->nullable(true);

            $table->foreignId('user_id')->nullable(false)->comment('id del usuario el cual creo el registro')
                ->references('id')->on('usuarios')->onDelete('restrict')->onUpdate('cascade');

            $table->date('fecha_inicio')->nullable(false)->comment('a partir de donde comienza esta lista de precio');
            $table->date('fecha_fin')->nullable(false)->comment('Cuando finaliza esta lista de precio');
        });
        DB::statement("CALL create_timestamps('price_list')");

        //------------------------------------------------------------------------------------
        //*TABLA CATEGORÍAS
        //?CATEGORÍAS 
        //------------------------------------------------------------------------------------
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500)->nullable(false);
            $table->unsignedBigInteger('father_category_id')->nullable(true); // Campo opcional
            $table->foreign('father_category_id')->references('id')->on('category')
                ->onDelete('cascade')->onUpdate('cascade'); // Elimina en cascada al borrar el padre

            $table->foreignId('user_id')->nullable(false)->comment('id del usuario el cual creo el registro')
                ->references('id')->on('usuarios')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        DB::statement("CALL create_timestamps('category')");


        //------------------------------------------------------------------------------------
        //*TABLA DE PRODUCTOS
        //?PRODUCTOS CABECERA
        //------------------------------------------------------------------------------------
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500)->nullable(false);
            $table->integer('sku')->unique()->nullable(true);
            $table->string('color', 100)->nullable(true);
            $table->enum('tipo', ['production', 'sale']);
            $table->string('reference', 300)->unique()->nullable(true);
            $table->string('talla', 5)->nullable(true);

            $table->foreignId('status_id')->nullable(false)->comment('id del usuario')
                ->references('id')->on('status')->onDelete('restrict')->onUpdate('cascade');

            $table->foreignId('category_id')->nullable(false)->comment('id del usuario')
                ->references('id')->on('category')->onDelete('restrict')->onUpdate('cascade');

            $table->foreignId('price_list_id')->nullable(true)->comment('id de la lista de precios')
                ->references('id')->on('price_list')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('user_id')->nullable(false)->comment('id del usuario el cual creo el registro')
                ->references('id')->on('usuarios')->onDelete('restrict')->onUpdate('cascade');
        });
        DB::statement("CALL create_timestamps('products')");

        //------------------------------------------------------------------------------------
        //*TABLA LISTA DE PRECIOS DETALLES
        //?DETALLES DE PRECIOS
        //------------------------------------------------------------------------------------
        Schema::create('price_list_detail', function (Blueprint $table) {
            $table->id();
            $table->float('price')->nullable(false);
            $table->float('net_price')->nullable(false);
            $table->integer('discount')->nullable(true);
            $table->integer('iva')->nullable(false);
            $table->boolean('active_discount')->nullable(false);

            $table->foreignId('product_id')->nullable(false)->comment('id del producto')
                ->references('id')->on('products')->onDelete('restrict')->onUpdate('cascade');

            $table->foreignId('price_list_id')->nullable(false)->comment('id de la lista de precios')
                ->references('id')->on('price_list')->onDelete('restrict')->onUpdate('cascade');


            $table->foreignId('user_id')->nullable(false)->comment('id del usuario el cual creo el registro')
                ->references('id')->on('usuarios')->onDelete('restrict')->onUpdate('cascade');
        });
        DB::statement("CALL create_timestamps('price_list_detail')");

        //------------------------------------------------------------------------------------
        //*TABLA DETALLE DE PRODUCTOS EN PRODUCCIÓN
        //?PRODUCTOS PARA PRODUCIR, ES DECIR MATERIA PRIMA
        //------------------------------------------------------------------------------------
        Schema::create('products_production', function (Blueprint $table) {

            $table->foreignId('product_id')->nullable(false)->unique()->comment('id del producto')
                ->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->json('detalle')->nullable(true)->comment('detalles del producto ');

            $table->foreignId('user_id')->nullable(false)->comment('id del usuario el cual creo el registro')
                ->references('id')->on('usuarios')->onDelete('restrict')->onUpdate('cascade');
        });
        DB::statement("CALL create_timestamps('products_production')");


        //------------------------------------------------------------------------------------
        //*TABLA PRODUCTOS EN UNA TIENDA 
        //?PRODUCTOS ASOCIADOS A TIENDAS
        //------------------------------------------------------------------------------------
        Schema::create('products_stores', function (Blueprint $table) {

            $table->foreignId('product_id')->nullable(false)->comment('id del producto')
                ->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('branch_id')->nullable(false)->comment('id de la tienda')
                ->references('id')->on('tiendas')->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('user_id')->nullable(false)->comment('id del usuario el cual creo el registro')
                ->references('id')->on('usuarios')->onDelete('restrict')->onUpdate('cascade');
        });
        DB::statement("CALL create_timestamps('products_stores')");


        //------------------------------------------------------------------------------------
        //*TABLA PRODUCTOS EN UNA ALMACEN
        //?PRODUCTOS ASOCIADOS A  ALMACENES
        //------------------------------------------------------------------------------------
        Schema::create('products_warehouses', function (Blueprint $table) {

            $table->foreignId('product_id')->nullable(false)->comment('id del producto')
                ->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('branch_id')->nullable(false)->comment('id del almacen')
                ->references('id')->on('almacenes')->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('user_id')->nullable(false)->comment('id del usuario el cual creo el registro')
                ->references('id')->on('usuarios')->onDelete('restrict')->onUpdate('cascade');
        });
        DB::statement("CALL create_timestamps('products_warehouses')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
        Schema::dropIfExists('price_list');
        Schema::dropIfExists('price_list_detail');
        Schema::dropIfExists('products');
        Schema::dropIfExists('products_production');
        Schema::dropIfExists('products_stores');
        Schema::dropIfExists('products_warehouses');
    }
}
