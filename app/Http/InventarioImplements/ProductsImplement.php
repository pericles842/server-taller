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
     * @param Illuminate\Support\Facades\DB $connection
     * @param string $name
     * @param integer $id
     * @param string $sku
     * @param string $color
     * @param string $tipo
     * @param string $reference
     * @param integer $status_id
     * @param integer $category_id
     * @param integer $price_list_id
     * @param integer $user_id
     * 
     * @return array
     * 
     */
    function createProduct(
        $connection,
        $id,
        $name,
        $sku,
        $color,
        $tipo,
        $reference,
        $talla,
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
            "talla" => strtoupper($talla),
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

        return  $product;
    }

    /**
     *Crea un producto para la producción, es decir crea la materia prima
     *
     * @param Illuminate\Support\Facades\DB $connection
     * @param integer $product_id
     * @param array $detalles
     * @param integer $user_id
     * 
     * @return array
     * 
     */
    function createProductProduction($connection, $product_id, $detalles, $user_id)
    {
        $product_production = [
            "product_id" => $product_id,
            "detalle" => $detalles,
            "user_id" => $user_id
        ];
        $connection->table('products_production')->insert($product_production);
    }

    /**
     * Crea un producto dinamicamente
     *
     * @param mixed $connection
     * @param mixed $product
     * @param array $detalle
     * 
     * @return array
     * 
     */
    function dynamicCreateProduct($connection, $user_id, $product, $detalle = [])
    {

        $data = $this->createProduct(
            $connection,
            $product['id'],
            $product['name'],
            $product['sku'],
            $product['color'],
            $product['tipo'],
            $product['reference'],
            $product['talla'],
            $product['status_id'],
            $product['category_id'],
            $product['price_list_id'],
            $user_id
        );
         
        if ($product['tipo'] == 'production') {
            $this->createProductProduction($connection, $data['id'], json_encode($detalle), $user_id);
            $data['detalles'] = $detalle;
        }

        return $data;
    }
}
