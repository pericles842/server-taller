<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class InventarioDataV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DATA TABLA ROLES
        DB::table('roles')->insert([
            [
                'name' => 'Super Usuario',
                "read" => 1,
                "write" => 1,
                "delete" => 1,
                "read_documents" => 1,
                "write_documents" => 1,
                "delete_documents" => 1,
            ],
            [
                'name' => 'Administrador',
                "read" => 1,
                "write" => 1,
                "delete" => 1,
                "read_documents" => 1,
                "write_documents" => 0,
                "delete_documents" => 0,
            ],
            [
                'name' => 'Jefe de almacén',
                "read" => 1,
                "write" => 1,
                "delete" => 0,
                "read_documents" => 1,
                "write_documents" => 1,
                "delete_documents" => 0,
            ],
            [
                'name' => 'Gerente de tienda',
                "read" => 1,
                "write" => 1,
                "delete" => 0,
                "read_notes" => 1,
                "write_notes" => 1,
                "delete_notes" => 0,
            ],
            [
                'name' => 'Empleado',
                "read" => 1,
                "write" => 0,
                "delete" => 0,
                "read_notes" => 1,
                "write_notes" => 0,
                "delete_notes" => 0,
            ],
        ]);

        DB::table('usuarios')->insert([
            "fulL_name" => 'Louis Sarmiento',
            "email" => 'slouis482@gmail.com',
            "ci" => '30329927',
            "direction" => 'Candelaria',
            "username" => '30329927',
            "password" => trim(Crypt::encryptString('admin')),
            "archivado" => '0',
            "rol_id" => '1'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('usuarios')->truncate();
        DB::table('roles')->truncate();
    }
}
