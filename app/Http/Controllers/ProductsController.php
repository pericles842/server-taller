<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\InventarioImplements\ProductsImplement;

class ProductsController extends Controller
{
    private $productsImplement;

    public function __construct(ProductsImplement $productsImplement)
    {
        $this->productsImplement = $productsImplement;
    }


    /**
     *Crea un producto dinamicamente
     *
     * @param Request $request
     * 
     * @return array
     * 
     */
    public function dynamicCreateProduct(Request $request)
    {
        try {

            if (!$request->header('user_id')) throw new \Exception("El encabezado 'user_id' es requerido", 400);
            // Definir las reglas de validación
            $validator = Validator::make($request->all(), [
                'product.name' => 'required|string',
                'product.id' => 'required',
                'product.tipo' => 'required|string',
                'product.category_id' => 'required|numeric',
                // 'product.price_list_id' => 'required|numeric',
                'product.status_id' => 'required|numeric'
            ]);
            
              
            // Verificar si la validación falla
            if ($validator->fails()) return response()->json($validator->errors(), 400);

            $response = $this->productsImplement->dynamicCreateProduct(
                DB::connection(),
                $request->header('user_id'),
                $request->product,
                $request->product['detalles']
            );
        } catch (\Exception $e) {

            return $e;
        }

        return response($response, 200)->header('Content-Type', 'application/json');
    }
}
