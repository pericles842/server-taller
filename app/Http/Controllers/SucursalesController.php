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
            if (!$request->filled('direction')) throw new \Exception("direction es requerido", 400);

            $data = $this->sucursalesImplement->createDynamicStore(
                DB::connection(),
                $request->only('id', 'name_store', 'direction')
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }


    /**
     * ASIGNA VARIOS USUARIOS A UNA SUCURSAL    
     *
     * @param Request $request
     * 
     * @return array
     * 
     */
    public function assignUserToBranch(Request $request)
    {
        try {
            if (!$request->filled('ids_users')) throw new \Exception(" ids_users es requerido", 400);
            if (!$request->filled('id_branch')) throw new \Exception("id_branch es requerido", 400);
            if (!$request->filled('type_branch')) throw new \Exception(" type_branch es requerido", 400);
            if (!$request->filled('ids_users_delete')) throw new \Exception(" ids_users_delete es requerido", 400);


            $data = $this->sucursalesImplement->assignUserToBranch(
                DB::connection(),
                $request->id_branch,
                $request->ids_users,
                $request->type_branch,
                $request->ids_users_delete
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    /**
     * Lista todos los almacenes
     *
     * @return [type]
     * 
     */
    public function listStore()
    {
        try {

            $data = $this->sucursalesImplement->listStore(
                DB::connection()
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    /**
     * Eliminar un alamacen
     *
     * @param mixed $store_id
     * 
     * @return [type]
     * 
     */
    public function deleteStore($store_id)
    {
        try {

            $data = $this->sucursalesImplement->deleteStore(
                DB::connection(),
                $store_id
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    /**
     *Cierra un almacen
     *
     * @param mixed $store_id
     * 
     * @return [type]
     * 
     */
    public function closeStore($store_id)
    {
        try {

            $data = $this->sucursalesImplement->closeStore(
                DB::connection(),
                $store_id
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    /**
     * crea y actualiza una tienda dinamicamente
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function createDynamicShop(Request $request)
    {
        try {
            if (!$request->filled('name_shop')) throw new \Exception("name_shop es requerido", 400);
            if (!$request->filled('direction')) throw new \Exception("direction es requerido", 400);

            $data = $this->sucursalesImplement->createDynamicShop(
                DB::connection(),
                $request->only('id', 'name_shop', 'direction')
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    /**
     *Cerrar una tienda
     *
     * @param mixed $shop_id
     * 
     * @return array
     * 
     */
    public function deleteShop($shop_id)
    {
        try {

            $data = $this->sucursalesImplement->deleteShop(
                DB::connection(),
                $shop_id
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    /**
     * Listar tiendas
     *
     * @return array
     * 
     */
    public function listShops()
    {
        try {

            $data = $this->sucursalesImplement->listShops(
                DB::connection()
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    /**
     * Cierra una tienda
     *
     * @param mixed $shop_id
     * 
     * @return [type]
     * 
     */
    public function closeShop($shop_id)
    {
        try {

            $data = $this->sucursalesImplement->closeShop(
                DB::connection(),
                $shop_id
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    /**
     * Lista los usuarios que no estan asignado a ninguna sucursal
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function listUserNotBranch(Request $request)
    {
        try {


            $data = $this->sucursalesImplement->listUserNotBranch(
                DB::connection(),
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    /**
     * Lista todas las sucursales tanto almacenes como tiendas abiertas
     *
     * @return array
     * 
     */
    public function getBranchAll()
    {
        try {


            $data = $this->sucursalesImplement->getBranchAll(
                DB::connection(),
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    /**
     *Obteine los usuarios de una sucursal
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function getUsersBranch(Request $request)
    {
        try {
            if (!$request->filled('type_branch')) throw new \Exception("type_branch es requerido", 400);
            if (!$request->filled('id_branch')) throw new \Exception("id_branch es requerido", 400);

            $data = $this->sucursalesImplement->getUsersBranch(
                DB::connection(),
                $request->type_branch,
                $request->id_branch
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }
}
