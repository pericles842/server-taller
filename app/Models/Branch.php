<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Branch
{
    public $table = '';
    public $table_primary_key = '';
    public $type_branch = '';

    public function __construct(string $type_branch)
    {

        if ($type_branch  == 'tienda') {
            $this->table = 'usuario_tienda';
            $this->table_primary_key = 'tienda_id';
            $this->type_branch = $type_branch;
        } else if ($type_branch == 'almacen') {

            $this->table = 'usuario_almacen';
            $this->table_primary_key = 'almacen_id';
            $this->type_branch = $type_branch;
        }
    }


    /**
     *asigna un usuario a una sucurusal
     *
     * @param int $branch_id
     * @param int $id_user
     * 
     * @return mixed
     * 
     */
    public function assignUserToBranch($branch_id, $id_user)
    {
        DB::table($this->table)->insert([
            $this->table_primary_key => $branch_id,
            "user_id" => $id_user
        ]);
    }

    /**
     * elimina un usuarios de una sucursal
     *
     * @param int $branch_id
     * @param int $id_user
     * 
     * @return mixed
     * 
     */
    public function removeUsersFBranch($branch_id, $id_user)
    {
        return DB::table($this->table)->where('user_id', $id_user)->where($this->table_primary_key, $branch_id)->delete();
    }
}
