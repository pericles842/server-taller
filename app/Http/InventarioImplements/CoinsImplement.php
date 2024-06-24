<?php

namespace App\Http\InventarioImplements;

class CoinsImplement
{

    /**
     * crea una nueva monda en el sistema
     *
     * @param Illuminate\Support\Facades\DB $connection 
     * @param array $data_coin 
     * 
     * @return array
     * 
     */
    private function createCurrency($connection, $data_coin)
    {
        $data_coin['id'] =  $connection->table('monedas')->insertGetId($data_coin);

        return $data_coin;
    }

    /**
     * Actualiza una moneda
     *
     * @param Illuminate\Support\Facades\DB  $connection
     * @param array $data_coin
     * 
     * @return array
     * 
     */
    private function updateCurrency($connection, $data_coin)
    {

        $connection->table('monedas')->where('id', $data_coin['id'])->update($data_coin);
        return $data_coin;
    }

    /**
     * Elimina una moneda
     *
     * @param mixed $connection
     * @param mixed $id
     * 
     * @return int
     * 
     */
    public function deleteCurrency($connection, $id)
    {
        $prev_coin = $connection->table('monedas')->where('id', $id)->first();
        if ($prev_coin->default == 0) throw new \Exception("No puedes borrar una moneda en uso", 400);

        return $connection->table('monedas')->where('id', $id)->delete();
    }

    /**
     * obtiene todas las monedas del sistema
     *
     * @param mixed $connection
     * 
     * @return array
     * 
     */
    public function getCoins($connection)
    {

        $monedas =   $connection->select("SELECT
        monedas.id,
        monedas.name,
        monedas.iso,
        monedas.default,
        CONCAT(
                '[',
                GROUP_CONCAT(
                        JSON_OBJECT(
                                'id',tasas.id,
                                'father_currency',monedas.name,
                                'price',tasas.price,
                                'created_at', tasas.created_at,
                                'updated_at', tasas.updated_at
                        )
                ),
                ']'
        ) AS tasas
        FROM    
        monedas
        LEFT JOIN tasas ON tasas.id_coin = monedas.id
        GROUP BY monedas.id
        ORDER BY monedas.default");

        foreach ($monedas as $key => $moneda) {
            $monedas[$key]->tasas = json_decode($moneda->tasas);
        }

        return $monedas;
    }

    /**
     * Crud dinámico de monedas
     *
     * @param  $connection
     * @param mixed $data
     * 
     * @return array
     * 
     */
    public function crudCoins($connection, $data)
    {

        //validamos el cambio de los default , editamos el anterior y le damos prioridad al actual
        if (intval($data['default']) == 1) {
            $prev_coin = $connection->table('monedas')->where('default', 1)->first();

            if (isset($prev_coin)) {
                $prev_coin->default = 0;
                $this->updateCurrency($connection, (array)$prev_coin);
            }
        }

        $data = empty($data['id']) ? $this->createCurrency($connection, $data) : $data = $this->updateCurrency($connection, $data);

        return $data;
    }

    /**
     * Guarda la tasa segun la moneda del sistema
     *
     * @param mixed $connection
     * @param int $id_coin
     * @param float $price
     * 
     * @return array
     * 
     */
    public function savePriceToACurrency($connection, $data)
    {
        $data['id'] = $connection->table('tasas')->insertGetId($data);
        return $data;
    }

    /**
     * actualiza la tasa de una moneda<
     *
     * @param mixed $connection
     * @param mixed $data
     * 
     * @return array
     * 
     */
    public function updatePriceToACurrency($connection, $data)
    {
        $data = [
            'price' => $data['price'],
            'id' => $data['id']
        ];

        $connection->table('tasas')->where('id', $data['id'])->update($data);
        return $data;
    }
}
