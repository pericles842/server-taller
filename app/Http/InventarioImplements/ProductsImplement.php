<?php

namespace App\Http\InventarioImplements;

class ProductsImplement
{

    /**
     * Crea y actualiza una categoría dinamicamente
     *
     * @param Illuminate\Support\Facades\DB $connection
     * @param mixed $category
     * 
     * @return array
     * 
     */
    function createCategory($connection, $category)
    {
        if ($category['id'] == null || $category['id'] == 0) {
            $category['id'] = $connection->table('category')->insertGetId($category);
        } else {
            $connection->table('category')->where('id', $category['id'])->update($category);
        }

        return $category;
    }

    /**
     * elimina una categoría
     *
     * @param Illuminate\Support\Facades\DB $connection
     * @param mixed $category
     * 
     * @return integer
     * 
     */
    function deleteCategory($connection, $id)
    {
        return $connection->table('category')->where('id', $id)->delete();
    }

    /**
     * crea y  actualiza dinamicamente
     *
     * @param mixed $connection
     * @param mixed $name
     * @param mixed $id
     * @param mixed $sku
     * @param mixed $color
     * @param mixed $tipo
     * @param mixed $reference
     * @param mixed $status_id
     * @param mixed $category_id
     * @param mixed $price_list_id
     * @param mixed $user_id
     * 
     * @return array
     * 
     */
    function createProductHeader(
        $connection,
        $name,
        $id,
        $sku,
        $color,
        $tipo,
        $reference,
        $status_id,
        $category_id,
        $price_list_id,
        $user_id
    ) {

        $product = [
            "id" => $id,
            "name" => $name,
            "sku" => $sku,
            "color" => $color,
            "tipo" => $tipo,
            "reference" => $reference,
            "status_id" => $status_id,
            "category_id" => $category_id,
            "price_list_id" => $price_list_id,
            "user_id" => $user_id,
        ];
        if ($id == null || $id == 0) {
            $product['id'] = $connection->table('products')->insertGetId($product);
        } else {
            $connection->table('products')->where('id', $id)->update($product);
        }
    }

    function createProductoProduction($connection, $product_id, $detalles, $user_id)
    {
        $product_production = [
            "product_id" => $product_id,
            "detalle" => $detalles,
            "user_id" => $user_id
        ];
        $connection->table('products_production')->insert($product_production);
    }

    function createProductSales() {

    }
}
