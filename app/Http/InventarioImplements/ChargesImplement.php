<?php

namespace App\Http\InventarioImplements;

class ChargesImplement
{

    /**
     * Obtiene la permisologia del usuario
     *
     * @param mixed $connection
     * @param mixed $user_id
     * 
     * @return [type]
     * 
     */
    public function getPermissionUser($connection, $user_id)
    {
        return $connection->selectOne("SELECT roles.modules FROM usuarios 
        INNER JOIN roles on roles.id  = usuarios.rol_id WHERE usuarios.id = :user_id", ["user_id" => $user_id])->modules;

    }
}
