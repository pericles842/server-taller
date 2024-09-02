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
            $connection->table('price_list')->where('id', $id)->update($body);
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

        return $connection->table('price_list')->get();
    }
}
