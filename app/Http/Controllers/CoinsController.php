<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\InventarioImplements\CoinsImplement;

class CoinsController extends Controller
{

    private $coinsImplement;

    public function __construct(CoinsImplement $coinsImplement)
    {
        $this->coinsImplement = $coinsImplement;
    }


    /**
     * ejecuta el metodo listar estatu , si no eres super usuario no se van a ver el registro de super usuario
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function listRoles(Request $request)
    {
        try {
          
        } catch (\Exception $e) {
            return $e;
        }

        return response([], 200)->header('Content-Type', 'application/json');
    }
}
