<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\InventarioImplements\PriceListImplement;

class PriceListController extends Controller
{
    private $priceListImplement;

    public function __construct(PriceListImplement $priceListImplement)
    {
        $this->priceListImplement = $priceListImplement;
    }

    /**
     * Crear lista de precio
     *
     * @param Request $request The incoming request object containing price list data.
     * @throws \Exception If the 'user_id' header is missing or if validation fails.
     * @return \Illuminate\Http\Response A JSON response containing the created price list data or error messages.
     */
    public function createPriceList(Request $request)
    {
        try {
            if (!$request->header('user_id')) throw new \Exception("El encabezado 'user_id' es requerido", 400);
            // Definir las reglas de validación
            $validator = Validator::make($request->all(), [
                'priceList.id' => 'required',
                'priceList.name' => 'required|string',
                'priceList.fecha_inicio' => 'required|string',
                'priceList.fecha_fin' => 'required|string'
            ]);
            // Verificar si la validación falla
            if ($validator->fails()) return response()->json($validator->errors(), 400);

            $response = $this->priceListImplement->createPriceList(
                DB::connection(),
                $request->priceList['name'],
                $request->header('user_id'),
                $request->priceList['description'],
                $request->priceList['fecha_inicio'],
                $request->priceList['fecha_fin'],
                $request->priceList['id']
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($response, 200)->header('Content-Type', 'application/json');
    }

    /**
     * Elimina una lista de precio por su ID
     *
     * @param int $id Id del registro para hacer el mach
     * @throws \Exception error de validación
     * @return \Illuminate\Http\Response A JSON response indicating the result of the deletion.
     */
    public function deletePriceList($id)
    {
        try {
            $response = $this->priceListImplement->deletePriceList(DB::connection(), $id);
        } catch (\Exception $e) {
            return $e;
        }

        return response($response, 200)->header('Content-Type', 'application/json');
    }
}
