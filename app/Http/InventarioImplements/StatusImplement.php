<?php

namespace App\Http\InventarioImplements;


class StatusImplement
{

    /**
     *Lista de roles , si el parámetro rol es 1 no se listara el super usuario
     *
     * @param mixed $connection
     * @param mixed $rol
     * 
     * @return [type]
     * 
     */
    public function listStatus($connection, $rol)
    {

        $select = "SELECT id , name FROM `roles` ";
        $where = " WHERE  id != 1 ";

        $query = $select . $where;
        
        if ($rol ==  1) $query = $select;  

        return $connection->select($query);
    }
}
