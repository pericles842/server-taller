<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\InventarioImplements\StatusImplement;

class StatusController extends Controller
{

    private $statusImplement;

    public function __construct(StatusImplement $statusImplement)
    {
        $this->statusImplement = $statusImplement;
    }


    /**
     * ejecuta el metodo listar estatu , si no eres super usuario no se van a ver el registro de super usuario
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function listStatus(Request $request)
    {
        try {

            if (!$request->filled('rol')) throw new \Exception("Roles requerido", 400);

            $response = $this->statusImplement->listStatus(
                DB::connection(),
                $request->rol
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($response, 200)->header('Content-Type', 'application/json');
    }
}
