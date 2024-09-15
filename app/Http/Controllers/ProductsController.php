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

    /**
     *Elimina un producto y sus conjuntos
     *
     * @param mixed $id
     * 
     * @return [type]
     * 
     */
    public function deleteProduct($id)
    {
        try {

            $data = $this->productsImplement->deleteProduct(DB::connection(), $id);
        } catch (\Exception $e) {

            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    /**
     *Crea una categoría
     *
     * @param Request $request
     * 
     * @return array
     * 
     */
    public function createCategory(Request $request)
    {
        try {

            if (!$request->header('user_id')) throw new \Exception("El encabezado 'user_id' es requerido", 400);
            $validator = Validator::make($request->all(), [
                'category.name' => 'required|string',
            ]);


            // Verificar si la validación falla
            if ($validator->fails()) return response()->json($validator->errors(), 400);

            $data = $this->productsImplement->createCategory(DB::connection(), $request->category, $request->header('user_id'));
        } catch (\Exception $e) {

            return $e;
        }

        return response($data, 200)->header('Content-Type', 'application/json');
    }

    /**
     * Deletes a category by its ID.
     *
     * @param mixed $id The ID of the category to delete
     * @throws \Exception If an error occurs during the deletion process
     * @return \Illuminate\Http\Response A JSON response with the deletion result
     */
    public function deleteCategory($id)
    {
        try {
            $data = $this->productsImplement->deleteCategory(DB::connection(), $id);
        } catch (\Exception $e) {
            return $e;
        }
        return response($data, 200)->header('Content-Type', 'application/json');
    }
    public function getCategories()
    {
        try {
            $data = $this->productsImplement->getCategories(DB::connection());
        } catch (\Exception $e) {
            return $e;
        }
        return response($data, 200)->header('Content-Type', 'application/json');
    }
    /**
     *estructura de categorias en arbol
     *
     * @throws \Exception si ocurre un error al obtener las categorías
     * @return \Illuminate\Http\Response  una respuesta con los datos de las categorías
     */
    public function getTreeCategories()
    {
        try {
            $data = $this->productsImplement->getTreeCategories(DB::connection());
        } catch (\Exception $e) {
            return $e;
        }
        return response($data, 200)->header('Content-Type', 'application/json');
    }


    /**
     *Crea y actualiza atributos de un producto
     *
     * @param Request $request
     * 
     * @return array
     * 
     */
    public function createProductsAttributes(Request $request)
    {

        try {
            $data = $this->productsImplement->createProductsAttributes(
                DB::connection(),
                $request->attribute_product['id'],
                $request->attribute_product['name'],
                $request->attribute_product['status_id'],
                $request->header('user_id'),
                $request->attribute_product['properties'],
            );
        } catch (\Exception $e) {

            return $e;
        }
        return response($data, 200)->header('Content-Type', 'application/json');
    }

    /**
     * Obtiene los atributos de los productos 
     *
     * @return \Illuminate\Http\Response  una respuesta con los datos de los atributos de los productos
     */
    public function getProductsAttributes()
    {

        try {
            $data = $this->productsImplement->getProductsAttributes(
                DB::connection()
            );
        } catch (\Exception $e) {

            return $e;
        }
        return response($data, 200)->header('Content-Type', 'application/json');
    }
}
