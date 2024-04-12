<?php

namespace App\Http\InventarioImplements;


class SucursalesImplement
{
    /**
     * Crear un almacen 
     *
     * @param mixed $connection
     * @param mixed $name
     * @param mixed $direction
     * @param mixed $status_id
     * 
     * @return array
     * 
     */
    function createStore($connection, $name, $direction, $status_id)
    {
        $data = [
            "name" => $name,
            "direction" => $direction,
            "status_id" => $status_id
        ];

        $data['id'] = $connection->table('almacenes')->insertGetId($data);

        return $data;
    }

    /**
     * Actualizar almacen
     *
     * @param mixed $connection
     * @param mixed $id
     * @param mixed $name
     * @param mixed $direction
     * @param mixed $status_id
     * 
     * @return [type]
     * 
     */
    function updateStore($connection, $id, $name, $direction, $status_id)
    {
        $data = [
            "name" => $name,
            "direction" => $direction,
            "status_id" => $status_id
        ];

        $connection->table('almacenes')->where('id', $id)->update($data);

        return $data;
    }

    /**
     * Actualizacion y creación de almacenes dinámicos
     *
     * @param mixed $connection
     * @param mixed $store
     * 
     * @return array
     * 
     */
    function createDynamicStore($connection, $store)
    {
        if (empty($store['id']) or $store['id'] == -1) {
            $store = self::createStore($connection, strtoupper($store['name_store']), $store['direction'], $store['status_id']);
        } else {
            $store = self::updateStore($connection, $store['id'], strtoupper($store['name_store']), $store['direction'], $store['status_id']);
        }

        return $store;
    }

    /**
     * Asignar un usuario a un almacen
     *
     * @param mixed $connection
     * @param mixed $id_store
     * @param mixed $id_user
     * 
     * @return array
     * 
     */
    function assignUserToStore($connection, $id_store, $id_user)
    {
        $data = [
            "user_id" => $id_user,
            "almacen_id" => $id_store
        ];

        $connection->table('usuario_almacen')->insert($data);

        return $data;
    }

    /**
     * Elimina un almacen 
     *
     * @param mixed $connection
     * @param integer $id_store
     * 
     * @return integer
     * 
     */
    function deleteStore($connection, $id_store)
    {
        return $connection->table('almacenes')->where('id', $id_store)->delete();
    }

    /**
     * Elimina un usuario de un alamcen
     *
     * @param mixed $connection
     * @param integer $id_store
     * @param integer $id_user
     * 
     * @return integer
     * 
     */
    function removeUserFromStore($connection, $id_store, $id_user)
    {
        return  $connection->table('almacenes')->where('user_id', $id_user)->where('almacen_id', $id_store)->delete();
    }
}
