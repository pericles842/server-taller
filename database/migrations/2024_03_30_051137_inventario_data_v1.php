<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Charges;

class InventarioDataV1 extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $charges = new Charges();
        // DATA TABLA ROLES
        DB::table('roles')->insert([
            [
                'name' => 'Propietario',
                'modules' => $charges->getChargeSuperAdmin()
            ],
            [
                'name' => 'Administrador',
                'modules' => $charges->getChargeAdmin()
            ],
            [
                'name' => 'Gerente de almacén',
                'modules' => $charges->getChargeWarehouseManager()
            ],
            [
                'name' => 'Gerente de tienda',
                'modules' => $charges->getChargeStoreManager()
            ],
            [
                'name' => 'Empleado',
                'modules' => $charges->getChargeJob()
            ]
        ]);

        //USUARIOS
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

        //ESTATUS
        DB::table('status')->insert(
            [
                [
                    "name" => "Abierto"
                ],
                [
                    "name" => "Cerrado"
                ],
                [
                    "name" => "Activo"
                ]
            ]
        );

        //MONEDA DEL SISTEMA
        DB::table('monedas')->insert(
            [
                "iso" => "USD",
                "symbol" => "$",
                "name" => "DOLAR",
                "default" => 1,
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('roles')->truncate();
        DB::table('usuarios')->truncate();
        DB::table('status')->truncate();
        DB::table('monedas')->truncate();
    }
}
