<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('roles')->truncate();
    }
}
