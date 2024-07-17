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

        //*TABLA CATEGORÍAS

        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500)->nullable(false);
            $table->foreignId('user_id')->nullable(false)->comment('id del usuario')
                ->references('id')->on('usuarios')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
        DB::statement("CALL create_timestamps('category')");


        //*TABLA LISTA DE PRECIOS

        Schema::create('price_list', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500)->nullable(false);
            $table->string('description', 800)->nullable(true);
            $table->float('price')->nullable(false);
            $table->integer('discount')->nullable(true);
            $table->boolean('active_discount')->nullable(false);
            $table->foreignId('category_id')->nullable(false)->comment('id de la categoría')
                ->references('id')->on('category')->onDelete('restrict')->onUpdate('cascade');

            $table->foreignId('user_id')->nullable(false)->comment('id del usuario')
                ->references('id')->on('usuarios')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
        DB::statement("CALL create_timestamps('price_list')");

        //*TABLA productos asociados a una lista de precios

        Schema::create('product_priceList', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable(false);
            $table->integer('price_list_id')->nullable(false);
        });
        DB::statement("CALL create_timestamps('product_priceList')");
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
        Schema::dropIfExists('product_priceList');
    }
}
