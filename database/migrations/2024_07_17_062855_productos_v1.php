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
        //------------------------------------------------------------------------------------
        Schema::create('price_list', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500)->nullable(false);
            $table->string('description', 800)->nullable(true);
            $table->float('price')->nullable(false);
            $table->float('price_unitario')->nullable(false);
            $table->integer('discount')->nullable(true);
            $table->integer('iva')->nullable(false);
            $table->boolean('active_discount')->nullable(false);

            $table->foreignId('user_id')->nullable(false)->comment('id del usuario el cual creo el registro')
                ->references('id')->on('usuarios')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
        DB::statement("CALL create_timestamps('price_list')");

        //------------------------------------------------------------------------------------
        //*TABLA CATEGORÍAS
        //------------------------------------------------------------------------------------
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500)->nullable(false);
            $table->foreignId('created_user_id')->nullable(false)->comment('id del usuario el cual creo el registro')
                ->references('id')->on('usuarios')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
        DB::statement("CALL create_timestamps('category')");

        //------------------------------------------------------------------------------------
        //*TABLA DE PRODUCTOS
        //------------------------------------------------------------------------------------
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500)->nullable(false);
            $table->integer('sku')->nullable(true);
            $table->string('color', 100)->nullable(true);
            $table->enum('tipo', ['production', 'sale']);

            $table->foreignId('status_id')->nullable(false)->comment('id del usuario')
                ->references('id')->on('status')->onDelete('restrict')->onUpdate('cascade');

            $table->foreignId('category_id')->nullable(false)->comment('id del usuario')
                ->references('id')->on('category')->onDelete('restrict')->onUpdate('cascade');

            $table->foreignId('created_user_id')->nullable(false)->comment('id del usuario el cual creo el registro')
                ->references('id')->on('usuarios')->onDelete('restrict')->onUpdate('cascade');
        });
        DB::statement("CALL create_timestamps('products')");

        //------------------------------------------------------------------------------------
        //*TABLA DETALLE DE PRODUCTOS DE VENTA
        //------------------------------------------------------------------------------------
        Schema::create('products_sales', function (Blueprint $table) {

            $table->foreignId('product_id')->nullable(false)->comment('id del producto')
                ->references('id')->on('products')->onDelete('restrict')->onUpdate('cascade');
            $table->string('talla', 5)->nullable(false);
            $table->string('reference', 300)->nullable(true);

            $table->foreignId('price_list_id')->nullable(false)->comment('id de la lista de precios')
                ->references('id')->on('price_list')->onDelete('restrict')->onUpdate('cascade');

            $table->foreignId('created_user_id')->nullable(false)->comment('id del usuario el cual creo el registro')
                ->references('id')->on('usuarios')->onDelete('restrict')->onUpdate('cascade');
        });
        DB::statement("CALL create_timestamps('products_sales')");

        //------------------------------------------------------------------------------------
        //*TABLA DETALLE DE PRODUCTOS EN PRODUCCIÓN
        //------------------------------------------------------------------------------------
        Schema::create('products_production', function (Blueprint $table) {

            $table->foreignId('product_id')->nullable(false)->comment('id del producto')
                ->references('id')->on('products')->onDelete('restrict')->onUpdate('cascade');
            $table->json('detalle')->nullable(true)->comment('detalles del producto ');


            $table->foreignId('price_list_id')->nullable(false)->comment('id de la lista de precios')
                ->references('id')->on('price_list')->onDelete('restrict')->onUpdate('cascade');

            $table->foreignId('created_user_id')->nullable(false)->comment('id del usuario el cual creo el registro')
                ->references('id')->on('usuarios')->onDelete('restrict')->onUpdate('cascade');
        });
        DB::statement("CALL create_timestamps('products_production')");
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('products_sales');
        Schema::dropIfExists('products_production');
    }
}
