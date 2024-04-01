<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InventarioV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE PROCEDURE create_timestamps(
            IN nombre_tabla VARCHAR(50)
        )
        BEGIN
            SET @sql = CONCAT(\'ALTER TABLE \', nombre_tabla, 
                              \' ADD created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
                              ADD updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;\');
            PREPARE stmt FROM @sql;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
        END
        ');

         //TABLA ROLES
         Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 300)->nullable(false)->comment('Nombre del rol');
            $table->integer('read')->nullable(false)->comment('lectura de formularios');
            $table->integer('write')->nullable(false)->comment('escritura de formularios');
            $table->integer('delete')->nullable(false)->comment('Borrar registros');
            $table->integer('read_documents')->nullable(false)->comment('lectura de documentos');
            $table->integer('write_documents')->nullable(false)->comment('escritura de documentos');
            $table->integer('delete_documents')->nullable(false)->comment('eliminación de documentos');
        });
        DB::statement("CALL create_timestamps('roles')");


        //TABLA USUARIOS
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('fulL_name', 300)->nullable(false)->comment('nombre del usuarios');
            $table->string('email', 500)->unique()->nullable(false)->comment('email del usuarios');
            $table->integer('ci')->unique()->nullable(false)->comment('cedula');
            $table->string('direction', 500)->nullable(true)->comment('direccion de la persona');
            $table->string('username', 300)->unique()->nullable(false)->comment('usuario del login');
            $table->string('password', 300)->unique()->nullable(false)->comment('contraseña login');

            $table->foreignId('rol_id')->nullable(false)->comment('ID del rol del usuario')
            ->references('id')->on('roles')
            ->onDelete('restrict')
            ->onUpdate('cascade');
        });
        DB::statement("CALL create_timestamps('usuarios')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS create_timestamps');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('roles');
    }
}
