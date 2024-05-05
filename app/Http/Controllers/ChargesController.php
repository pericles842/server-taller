<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\InventarioImplements\ChargesImplement;

class ChargesController extends Controller
{   

    private $chargesImplement;

    public function __construct(ChargesImplement $chargesImplement)
    {
        $this->chargesImplement = $chargesImplement;
    }


    /**
     * ejecuta el metodo listar estatu , si no eres super usuario no se van a ver el registro de super usuario
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function getPermissionUser(Request $request)
    {
        try {
            if (!$request->header('user_id')) throw new \Exception("El encabezado 'user_id' es requerido", 400);

            $response = $this->chargesImplement->getPermissionUser(
                DB::connection(),
                $request->header('user_id')
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($response, 200)->header('Content-Type', 'application/json');
    }
}
