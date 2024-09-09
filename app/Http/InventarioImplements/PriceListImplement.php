<?php

namespace App\Http\InventarioImplements;

class PriceListImplement
{

    /**
     *Crear actualizar lista de precios dinamicamente
     *
     * @param Illuminate\Support\Facades\DB $connection
     * @param string $name
     * @param string $description
     * @param integer $user_id
     * @param mixed $start_date
     * @param mixed $end_date
     * @param integer $id
     * 
     * @return array
     * 
     */
    function createPriceList($connection, $name, $description, $user_id, $start_date, $end_date, $id)
    {
        $body = [
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "user_id" => $user_id,
            "fecha_inicio" => $start_date,
            "fecha_fin" => $end_date
        ];

        if ($id == 0 || $id == null) {
            $body['id'] = $connection->table('price_list')->insertGetId($body);
        } else {
            $connection->table('price_list')->where('id', $body['id'])->update($body);
        }

        return $body;
    }

    /**
     * Elimina una lista de precios
     *
     * @param Illuminate\Support\Facades\DB  $connection
     * @param integer $id
     * 
     * @return integer
     * 
     */
    function deletePriceList($connection, $id)
    {
        return $connection->table('category')->where('id', $id)->delete();
    }


    /**
     * obtiene una lista de precios
     *
     * @param mixed $connection
     * 
     * @return array
     * 
     */
    function getPriceList($connection)
    {

        $price_lists = $connection->select("SELECT
                price_list.*,
                concat(
                    '[',
                    IF(
                        COUNT(price_list_detail.id) > 0,
                        GROUP_CONCAT(
                            JSON_OBJECT(
                                'price_list_detail_id', price_list_detail.id,
                                'product_id', p.id,
                                'product_name', p.name,
                                'categoria', c.name,
                                'price', price_list_detail.price,
                                'net_price', price_list_detail.net_price,
                                'discount', price_list_detail.discount,
                                'iva', price_list_detail.iva,
                                'active_discount', price_list_detail.active_discount
                            )
                        ),
                        ''
                    ),
                    ']'
                ) as price_list_details
            FROM price_list
            LEFT JOIN price_list_detail ON price_list.id = price_list_detail.price_list_id 
            LEFT JOIN products as p ON p.id = price_list_detail.product_id
            LEFT JOIN category as c ON c.id = p.category_id 
            GROUP BY price_list.id;");

        foreach ($price_lists as $key => $price_list) {
            $price_lists[$key]->price_list_details = json_decode($price_list->price_list_details);
        }

        return $price_lists;
    }
}
