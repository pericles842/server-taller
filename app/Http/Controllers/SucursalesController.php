<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\InventarioImplements\SucursalesImplement;

class SucursalesController extends Controller
{

    private $sucursalesImplement;

    public function __construct(SucursalesImplement $sucursalesImplement)
    {
        $this->sucursalesImplement = $sucursalesImplement;
    }


    /**
     * crea un almacen dinamicamente
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function createDynamicStore(Request $request)
    {
        try {
            if (!$request->filled('name_store')) throw new \Exception("name_store es requerido", 400);
            if (!$request->filled('status_id')) throw new \Exception("status_id es requerido", 400);
            if (!$request->filled('direction')) throw new \Exception("direction es requerido", 400);

            $data = $this->sucursalesImplement->createDynamicStore(
                DB::connection(),
                $request->only('id', 'name_store', 'direction', 'status_id')
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }
        
    /**
     * Asigna un usuario a un almacen
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function assignUserToStore(Request $request)
    {
        try {
            if (!$request->filled('almacen_id')) throw new \Exception("id_almacen es requerido", 400);
            if (!$request->filled('user_id')) throw new \Exception(" user_id es requerido", 400);


            $data = $this->sucursalesImplement->assignUserToStore(
                DB::connection(),
                $request->almacen_id,
                $request->user_id
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }
}
