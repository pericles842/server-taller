<?php

namespace App\Http\InventarioImplements;

use App\Models\Branch;

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
        $data['id'] = $id;
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
            $store = self::createStore($connection, strtoupper($store['name_store']), $store['direction'], 1);
        } else {
            $store = self::updateStore($connection, $store['id'], strtoupper($store['name_store']), $store['direction'], 1);
        }

        return $store;
    }

    /**
     * Listar usuarios
     *
     * @param mixed $connection
     * 
     * @return array
     * 
     */
    function listStore($connection)
    {
        return $connection->select("SELECT almacenes.id, almacenes.name name_store, almacenes.direction ,almacenes.status_id, st.name estatus FROM almacenes 
        INNER JOIN status st ON st.id = almacenes.status_id");
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


    /**
     * Cierra un almacen
     *
     * @param mixed $connection
     * @param mixed $id
     * 
     * @return mixed
     * 
     */
    function closeStore($connection, $id)
    {
        $connection->table('almacenes')->where('id', $id)->update(["status_id" => 2]);
    }

    /**
     * Crear tienda 
     *
     * @param mixed $connection
     * @param mixed $name
     * @param mixed $direction
     * @param mixed $status_id
     * 
     * @return array
     * 
     */
    function createShop($connection, $name, $direction, $status_id)
    {

        $data = [
            "name" => $name,
            "direction" => $direction,
            "status_id" => $status_id
        ];

        $data['id'] = $connection->table('tiendas')->insertGetId($data);

        return $data;
    }

    /**
     * Actualizar una tienda        
     *
     * @param mixed $connection
     * @param mixed $id
     * @param mixed $name
     * @param mixed $direction
     * @param mixed $status_id
     * 
     * @return array
     * 
     */
    function updateShop($connection, $id, $name, $direction, $status_id)
    {
        $data = [
            "name" => $name,
            "direction" => $direction,
            "status_id" => $status_id
        ];

        $connection->table('tiendas')->where('id', $id)->update($data);

        $data['id'] = $id;

        return $data;
    }

    /**
     *  Crea y actualiza una tienda dinamicamente
     *
     * @param mixed $connection
     * @param mixed $store
     * 
     * @return array
     * 
     */
    function createDynamicShop($connection, $shop)
    {
        if (empty($shop['id']) or $shop['id'] == -1) {
            $shop = self::createShop($connection, strtoupper($shop['name_shop']), $shop['direction'], 1);
        } else {
            $shop = self::updateShop($connection, $shop['id'], strtoupper($shop['name_shop']), $shop['direction'], 1);
        }

        return $shop;
    }

    /**
     * Lista las tiendas
     *
     * @param mixed $connection
     * 
     * @return [type]
     * 
     */
    function listShops($connection)
    {
        return $connection->select("SELECT tiendas.id, tiendas.name name_shop, tiendas.direction ,tiendas.status_id, st.name estatus FROM tiendas 
        INNER JOIN status st ON st.id = tiendas.status_id");
    }

    /**
     *Elimina una tienda
     *
     * @param mixed $connection
     * @param mixed $id_shop
     * 
     * @return [type]
     * 
     */
    function deleteShop($connection, $id_shop)
    {
        return $connection->table('tiendas')->where('id', $id_shop)->delete();
    }

    /**
     * Cierra una tienda
     *
     * @param mixed $connection
     * @param mixed $id
     * 
     * @return mixed
     * 
     */
    function closeShop($connection, $id)
    {
        $connection->table('tiendas')->where('id', $id)->update(["status_id" => 2]);
    }

    /**
     * Lista los usuarios que no estan asignados a nuguna sucursal
     *
     * @param mixed $connection
     * 
     * @return array
     * 
     */
    function listUserNotBranch($connection)
    {
        return  $connection->select('SELECT user.id user_id ,
        user.fulL_name name_user,
        user.email,
        roles.name cargo,
        user.rol_id,
        user.direction,
        user.username,
        user.ci
    FROM usuarios user
        LEFT JOIN usuario_tienda tienda ON user.id = tienda.user_id
        LEFT JOIN usuario_almacen almacen ON user.id = almacen.user_id
        INNER JOIN roles ON roles.id = user.rol_id
    WHERE
        tienda.user_id IS NULL AND
        almacen.user_id IS NULL AND
        user.archivado != 1 AND
        user.rol_id NOT IN (1, 2)');
    }

    /**
     * Obtener todas las sucursales disponibles
     *
     * @param mixed $connection
     * 
     * @return array
     * 
     */
    function getBranchAll($connection)
    {
        return  $connection->select("SELECT 'almacen' AS type, a.id, a.name , a.direction
       FROM almacenes a
       WHERE a.status_id != 2
        UNION ALL
       SELECT 'tienda' AS type, t.id, t.name ,t.direction
       FROM tiendas t
       WHERE t.status_id != 2;");
    }


    /**
     *Retorna los usuarios de una sucursal
     *
     * @param mixed $connection
     * @param mixed $type_brach
     * @param mixed $id_branch
     * 
     * @return array
     * 
     */
    function getUsersBranch($connection, $type_branch, $id_branch)
    {

        $body = '';

        if ($type_branch === 'almacen') {
            $body =  $connection->select("SELECT 
            user.id user_id,
            almacenes.id sucursal_id ,
            user.rol_id,
            almacenes.name ,
            almacenes.direction,
            user.fulL_name name_user ,
            user.email,
            roles.name cargo
            FROM usuarios user 
        LEFT JOIN usuario_almacen ON usuario_almacen.user_id = user.id
        INNER JOIN almacenes ON usuario_almacen.almacen_id = almacenes.id
        INNER JOIN roles ON user.rol_id = roles.id
        WHERE  almacenes.status_id != 2  AND  almacenes.id = :id ", [
                'id' => $id_branch
            ]);
        } else {
            $body = $connection->select("SELECT 
            user.id user_id,
            tiendas.id sucursal_id ,
            user.rol_id,
            tiendas.name ,
            tiendas.direction,
            user.fulL_name  name_user,
            user.email,
            roles.name cargo
            FROM usuarios user 
            LEFT JOIN usuario_tienda ON usuario_tienda.user_id = user.id
            INNER JOIN tiendas ON usuario_tienda.tienda_id = tiendas.id
            INNER JOIN roles ON user.rol_id = roles.id
            WHERE tiendas.status_id != 2 AND tiendas.id = :id ", [
                "id" => $id_branch
            ]);
        }


        foreach ($body as $key => $item) {
            $item->typeBranch = $type_branch;
        }
        return $body;
    }

    /**
     * ASIGNA VARIOS USUARIOS A UNA SUCURSAL
     *
     * @param mixed $connection
     * @param mixed $id_branch
     * @param mixed $ids_users
     * @param mixed $type_brach
     * 
     * @return array
     * 
     */
    function assignUserToBranch($connection, $id_branch, $ids_users, $type_branch,$ids_users_delete)
    {
        $branch = new Branch($type_branch);

        $ids_users_create = self::validateUsersBranch($connection, $id_branch, $ids_users, $type_branch);

        foreach ($ids_users_create as $id_user) {
            $branch->assignUserToBranch($id_branch, $id_user);
        }

        foreach ($ids_users_delete as $id_user) {
            $branch->removeUsersFBranch($id_branch, $id_user);
        }
         $data = [
             "sucursal_id" => $id_branch,
             "typeBranch" => $type_branch,
             "users_ids" => $ids_users
         ];

        return $data;  
    }

    /**
     * La validación se encargara de retornar los usuarios que no existen en base a los ids_users array
     *
     * @param object $connection
     * @param int $id_branch
     * @param array $ids_users
     * @param string $type_branch
     * 
     * @return array
     * 
     */
    function validateUsersBranch($connection, $id_branch, $ids_users, $type_branch): array
    {
        $branch_table = new Branch($type_branch);

        $ids_query = $connection->table($branch_table->table)
            ->where($branch_table->table_primary_key, $id_branch)
            ->pluck('user_id')->all();

        //comparamos los arregos y retornaa los que no existen 
        return array_values(array_diff($ids_users, $ids_query));
    }
}
