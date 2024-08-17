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
    function createCategory($connection, $category, $user_id)
    {
        $data = [
            "id" => $category['id'],
            "name" => ucfirst(trim($category['name'])),
            "father_category_id" => $category['father_category_id'],
            "user_id" => intval($user_id)
        ];
        if ($data['id'] == null || $data['id'] == 0) {
            //setea la categoria padre en nullo si esta en 0
            if ($data['father_category_id'] == 0) $data['father_category_id'] = null;

            $data['id'] = $connection->table('category')->insertGetId($data);
        } else {
            $connection->table('category')->where('id', $data['id'])->update($data);
        }

        return $data;
    }

    /**
     * Obtiene todas las categorías
     *
     * @param Illuminate\Support\Facades\DB $connection
     * 
     * @return array
     * 
     */
    function getCategories($connection)
    {
        return $connection->select("SELECT
                    category.id,
                    category.name,
                    category.father_category_id,
                    GROUP_CONCAT(C.name SEPARATOR ' -> ') AS tree_minimalist,
                    category.user_id
        FROM category
        LEFT JOIN category AS C ON C.father_category_id = category.id
        GROUP BY category.id 
        ORDER BY category.name ASC;");
    }

    /**
     * Obtiene todas las categorías y las devuelve como un árbol jerárquico en formato JSON.
     *
     * @param Illuminate\Support\Facades\DB $connection Conexión a la base de datos.
     * @return response JSON con el árbol de categorías.
     */
    function getTreeCategories($connection)
    {
        // Consulta SQL para obtener todas las categorías
        $categories =   $connection->table('category')->get();

        // Convertir el resultado en un array asociativo
        $categories = json_decode(json_encode($categories), true);

        // Construir el árbol desde el array plano
        return  $this->buildTree($categories);
    }

    /**
     * Construye el árbol de categorías a partir de un arreglo plano.
     *
     * @param array $categories Arreglo de categorías.
     * @param int|null $fatherId ID del padre de la categoría.
     * @return array Árbol de categorías.
     */
    private function buildTree(array &$categories, $fatherId = null)
    {
        $branch = [];

        foreach ($categories as &$category) {
            if ($category['father_category_id'] == $fatherId) {

                $children = $this->buildTree($categories, $category['id']);
                if ($children) {
                    $category['children'] = $children;
                } else {
                    $category['children'] = [];
                }
                $category['expanded'] = true;
                $branch[] = $category;
            }
        }

        return $branch;
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
            "user_id" => $user_id
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
     *actualiza un producto para la producción, es decir crea la materia prima
     *
     * @param Illuminate\Support\Facades\DB $connection
     * @param integer $product_id
     * @param array $detalles
     * @param integer $user_id
     * 
     * @return array
     * 
     */
    function updateProductProduction($connection, $product_id, $detalles, $user_id)
    {
        $product_production = [
            "detalle" => $detalles,
            "user_id" => $user_id
        ];

        $connection->table('products_production')->where('product_id', $product_id)->update($product_production);
    }
    /**
     * Crea un producto dinamicamente
     *
     * @param Illuminate\Support\Facades\DB $connection
     * @param int $user_id
     * @param array $product
     * @param mixed $connection
     * @param mixed $product
     * @param array $detalle
     *
     * 
     * @return array
     * 
     */
    function dynamicCreateProduct($connection, int $user_id, array $product, array $detalle = []): array
    {

        if ($product['tipo'] == 'sale' && $product['price_list_id'] == null) throw new \Exception("Los productos para la venta debe tener
         'price_list_id' requerido", 400);



        $data = $this->createProduct(
            $connection,
            $product['id'],
            ucfirst(trim($product['name'])),
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

            //nombre de los metodos
            $method = $product['id'] == 0 ? 'createProductProduction' : 'updateProductProduction';

            $this->$method($connection, $data['id'], json_encode($detalle), $user_id);
            $data['detalles'] = $detalle;
        }

        return $data;
    }

    /**
     * Eliminar un producto
     *
     * @param mixed $connection
     * @param mixed $id
     * 
     * @return mixed
     * 
     */
    function deleteProduct($connection, $id)
    {
        return $connection->table('products')->where('id', $id)->delete();
    }

    /**
     * Asigna un producto a una sucursal
     *
     * @param mixed $connection
     * @param mixed $product_id
     * @param mixed $branch_id
     * @param mixed $user_id
     * @param mixed $type_branch
     * 
     * @return array
     * 
     */
    function  assignProductToBranch($connection, $product_id, $branch_id, $user_id, $type_branch)
    {
        $table = [
            'almacen' => 'products_warehouses',
            'tienda' => 'products_stores'
        ];

        return $connection->table($table[$type_branch])->insert([
            'product_id' => $product_id,
            'branch_id' => $branch_id,
            'user_id' => $user_id
        ]);
    }

    /**
     * Actualiza un producto asignado a una sucursal
     *
     * @param mixed $connection The database connection object.
     * @param int $product_id The ID of the product to update.
     * @param int $branch_id The ID of the branch to assign to the product.
     * @param int $user_id The ID of the user to assign to the product.
     * @param string $type_branch The type of branch ('almacen' or 'tienda').
     * @return int The number of rows affected by the update query.
     */
    function  updateProductsAssignedToBranches($connection, $product_id, $branch_id, $user_id, $type_branch)
    {
        $table = [
            'almacen' => 'products_warehouses',
            'tienda' => 'products_stores'
        ];

        return $connection->table($table[$type_branch])->where('product_id', $product_id)->where('branch_id', $branch_id)
            ->update([
                'branch_id' => $branch_id,
                'user_id' => $user_id
            ]);
    }

    /**
     * Elimina un producto asignado a una sucursal
     *
     * @param mixed $connection
     * @param mixed $product_id
     * @param mixed $type_branch
     * 
     * @return [type]
     * 
     */
    function deleteProductsAssignedToBranches($connection, $product_id, $branch_id, $type_branch)
    {
        $table = [
            'almacen' => 'products_branches',
            'tienda' => 'products_stores'
        ];
        return $connection->table($table[$type_branch])->where('product_id', $product_id)->where('branch_id', $branch_id)->delete();
    }
}
