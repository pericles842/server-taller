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
     * Guarda y actualiza dinamicamente
     *
     * @param Request $request
     * 
     * @return array
     * 
     */
    public function crudCoins(Request $request)
    {
        try {
            if (!$request->filled('moneda')) throw new \Exception("moneda es requerido", 400);
            $response = $this->coinsImplement->crudCoins(DB::connection(), $request->moneda);
        } catch (\Exception $e) {
            return $e;
        }

        return response($response, 200)->header('Content-Type', 'application/json');
    }

    /**
     * Elimina una moneda
     *
     * @param Request $request
     * @param mixed $id
     * 
     * @return integer
     * 
     */
    public function deleteCoin($id)
    {
        try {
            if (empty($id)) throw new \Exception("id del registro es requerido", 400);

            $response = $this->coinsImplement->deleteCurrency(DB::connection(), $id);
        } catch (\Exception $e) {
            return $e;
        }

        return response($response, 200)->header('Content-Type', 'application/json');
    }

    /**
     * Obtiene todas las monedas
     *
     * @param Request $request
     * 
     * @return array
     * 
     */
    public function getCoins(Request $request)
    {
        try {
            $response = $this->coinsImplement->getCoins(DB::connection());
        } catch (\Exception $e) {
            return $e;
        }

        return response($response, 200)->header('Content-Type', 'application/json');
    }
}