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
        return  $connection->table('monedas')->get();
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
    public function saveCurrencyPrecio($connection, int $id_coin,  float $price)
    {
        $data = ["id_coin" => $id_coin, "price" => $price];
        return $connection->table('tasas')->insert($data);
    }
}
