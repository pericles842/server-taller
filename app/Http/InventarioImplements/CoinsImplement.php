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
        if ($prev_coin->default == 1) throw new \Exception("No puedes borrar una moneda en uso", 400);

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
        //VALIDA Y ELIMINA LAS TASAS VIEJAS
        // $this->validateCreateRate($connection);

        $monedas =   $connection->select("SELECT
    monedas.id,
    monedas.name,
    monedas.iso,
    monedas.symbol,
    monedas.default,
    CONCAT(
        '[',
        IF(
            COUNT(tasas.id) > 0,
            GROUP_CONCAT(
                JSON_OBJECT(
                    'id', tasas.id,
                    'father_currency', monedas.name,
                    'price', tasas.price,
                    'price_symbol', concat(tasas.price,' ',monedas.symbol),
                    'created_at', tasas.created_at,
                    'updated_at', tasas.updated_at
                )
            ),
            ''
        ),
        ']'
    ) as tasas
    FROM monedas
    LEFT JOIN 
        tasas ON tasas.id_coin = monedas.id
    GROUP BY monedas.id
    ORDER BY monedas.default;");

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

        $data = (empty($data['id']) or  $data['id'] == -1) ?  $this->createCurrency($connection, $data) : $this->updateCurrency($connection, $data);

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

    /**
     * Elimina una tasa
     *
     * @param mixed $connection
     * @param mixed $id
     * 
     * @return mixed
     * 
     */
    public function deletePriceToCurrency($connection, $id)
    {
        return $connection->table('tasas')->where('id', $id)->delete();
    }
}
