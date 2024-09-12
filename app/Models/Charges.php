<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use stdClass;

class Charges
{
    private $template_charges =  [
        "rol" => [
            "cargo" => "Cargo"
        ],
        1 => [
            "id" => 1,
            "label" => "Usuarios",
            "authorized" => false,
            "create" => false,
            "update" => false,
            "delete" => false
        ],
        2 => [
            "id" => 2,
            "label" => "Monedas",
            "authorized" => false,
            "create" => false,
            "update" => false,
            "delete" => false
        ],
        3 => [
            "id" => 3,
            "label" => "Cargos",
            "authorized" => false,
            "create" => false,
            "update" => false,
            "delete" => false
        ],
        4 => [
            "id" => 4,
            "label" => "Tiendas",
            "authorized" => false,
            "create" => false,
            "update" => false,
            "delete" => false
        ],
        5 => [
            "id" => 5,
            "label" => "Almacenes",
            "authorized" => false,
            "create" => false,
            "update" => false,
            "delete" => false
        ],
        6 => [
            "id" => 6,
            "label" => "Sucursales",
            "authorized" => false,
            "create" => false,
            "update" => false,
            "delete" => false
        ],
        16 => [
            "id" => 16,
            "label" => "Categorías",
            "authorized" => false,
            "create" => false,
            "update" => false,
            "delete" => false
        ],
        17 => [
            "id" => 17,
            "label" => "Lista de precios",
            "authorized" => false,
            "create" => false,
            "update" => false,
            "delete" => false
        ],
        18 => [
            "id" => 18,
            "label" => "Atributos de productos",
            "authorized" => false,
            "create" => false,
            "update" => false,
            "delete" => false
        ],
        7 => [
            "id" => 7,
            "label" => "Productos",
            "authorized" => false,
            "create" => false,
            "update" => false,
            "delete" => false
        ],
        8 => [
            "id" => 8,
            "label" => "Inventario",
            "authorized" => false,
            "create" => false,
            "update" => false,
            "delete" => false
        ],
        9 => [
            "id" => 9,
            "label" => "Notas",
            "authorized" => false,
            10 => [
                "id" => 10,
                "parent_id" => 9,
                "label" => "Entrada",
                "authorized" => false,
                "create" => false,
                "update" => false,
                "delete" => false
            ],
            11 => [
                "id" => 11,
                "parent_id" => 9,
                "label" => "Movimiento",
                "authorized" => false,
                "create" => false,
                "update" => false,
                "delete" => false
            ],
            12 => [
                "id" => 12,
                "parent_id" => 9,
                "label" => "Devolución",
                "authorized" => false,
                "create" => false,
                "update" => false,
                "delete" => false
            ],
            13 => [
                "id" => 13,
                "parent_id" => 9,
                "label" => "Salida",
                "authorized" => false,
                "create" => false,
                "update" => false,
                "delete" => false
            ],
            14 => [
                "id" => 14,
                "parent_id" => 9,
                "label" => "Venta",
                "authorized" => false,
                "create" => false,
                "update" => false,
                "delete" => false
            ]
        ],
        15 => [
            "id" => 15,
            "label" => "Reportes",
            "authorized" => false,
            "create" => false,
            "update" => false,
            "delete" => false
        ]
    ];



    /**
     * retorna un objeto con la configuración del cargo 
     *
     * @param string $name_rol
     * @param mixed $module_permissions
     * 
     * @return mixed
     * 
     */
    function defineRole(string $name_rol, array $module_permissions, bool $json_string = true)
    {
        $config = [];
        foreach ($this->template_charges as $key_template => $module) {

            if ($key_template == 'rol') $module['cargo'] = $name_rol;

            foreach ($module_permissions as $key_config => $config_module) {
                $permissions = new stdClass();

                //Cuneta como permission_settings ALL 
                $permissions->authorized = true;
                $permissions->create = true;
                $permissions->update = true;
                $permissions->delete = true;

                if ($config_module['id'] == $key_template || (isset($config_module['parent_id']) && $config_module['parent_id'] == $key_template)) {
                    if ($config_module['permission_settings'] == 'manual') {
                        $permissions = $this->assignPermissions($config_module);
                    }

                    if (isset($module[$config_module['id']])) {
                        $module[$config_module['id']]['authorized'] = $permissions->authorized;
                        $module[$config_module['id']]['create'] = $permissions->create;
                        $module[$config_module['id']]['update'] = $permissions->update;
                        $module[$config_module['id']]['delete'] = $permissions->delete;
                    } else {
                        $module['authorized'] = $permissions->authorized;
                        $module['create'] = $permissions->create;
                        $module['update'] = $permissions->update;
                        $module['delete'] = $permissions->delete;
                    }
                }
            }
            $config[] = $module;
        }

        return $json_string ? json_encode($config) : $config;
    }
    /**
     *Retorna un  objeto con los permisos asignar
     *
     * @param mixed $config_module
     * 
     * @return [type]
     * 
     */
    private function assignPermissions($config_module)
    {
        $permissions = new stdClass();

        $permissions->authorized = $config_module['authorized'];
        $permissions->create = $config_module['create'];
        $permissions->update = $config_module['update'];
        $permissions->delete = $config_module['delete'];

        return  $permissions;
    }

    public function getChargeSuperAdmin()
    {
        $super_admin_config = [
            [
                "id" => 1,
                "permission_settings" => "all"
            ],
            [
                "id" => 2,
                "permission_settings" => "all"
            ],
            [
                "id" => 3,
                "permission_settings" => "all"
            ],
            [
                "id" => 4,
                "permission_settings" => "all"
            ],
            [
                "id" => 5,
                "permission_settings" => "all"
            ],
            [
                "id" => 16,
                "permission_settings" => "all"
            ],
            [
                "id" => 17,
                "permission_settings" => "all"
            ],
            [
                "id" => 18,
                "permission_settings" => "all"
            ],
            [
                "id" => 6,
                "permission_settings" => "all"
            ],
            [
                "id" => 7,
                "permission_settings" => "all"
            ],
            [
                "id" => 8,
                "permission_settings" => "all"
            ],
            [
                "id" => 9,
                "permission_settings" => "all"
            ],
            [
                "id" => 10,
                "permission_settings" => "all",
                "parent_id" => 9,
            ],
            [
                "id" => 11,
                "permission_settings" => "all",
                "parent_id" => 9,
            ],
            [
                "id" => 12,
                "permission_settings" => "all",
                "parent_id" => 9,
            ],
            [
                "id" => 13,
                "permission_settings" => "all",
                "parent_id" => 9,
            ],
            [
                "id" => 14,
                "permission_settings" => "all",
                "parent_id" => 9,
            ],
            [
                "id" => 15,
                "permission_settings" => "all"
            ]
        ];
        return $this->defineRole('Propietario', $super_admin_config);
    }

    public function getChargeAdmin()
    {
        $admin_config = [
            [
                "id" => 1,
                "permission_settings" => "all",

            ],
            [
                "id" => 2,
                "permission_settings" => "all"
            ],
            [
                "id" => 3,
                "permission_settings" => "manual",
                "authorized" => true,
                "create" => true,
                "update" => true,
                "delete" => false
            ],
            [
                "id" => 4,
                "permission_settings" => "manual",
                "authorized" => true,
                "create" => true,
                "update" => false,
                "delete" => false
            ],
            [
                "id" => 5,
                "permission_settings" => "manual",
                "authorized" => true,
                "create" => true,
                "update" => false,
                "delete" => false
            ],
            [
                "id" => 16,
                "permission_settings" => "all"
            ],
            [
                "id" => 17,
                "permission_settings" => "all"
            ],
            [
                "id" => 18,
                "permission_settings" => "all"
            ],
            [
                "id" => 6,
                "permission_settings" => "all"
            ],
            [
                "id" => 7,
                "permission_settings" => "all"
            ],
            [
                "id" => 8,
                "permission_settings" => "all"
            ],
            [
                "id" => 15,
                "permission_settings" => "all",
            ]
        ];

        return $this->defineRole('Administrador', $admin_config);
    }

    public function getChargeWarehouseManager()
    {
        $warehouse_manager_config = [
            [
                "id" => 7,
                "permission_settings" => "manual",
                "authorized" => true,
                "create" => true,
                "update" => true,
                "delete" => false

            ],
            [
                "id" => 8,
                "permission_settings" => "all"
            ],
            [
                "id" => 9,
                "permission_settings" => "all"

            ],
            [
                "id" => 10,
                "permission_settings" => "all",
                "parent_id" => 9

            ],
            [
                "id" => 11,
                "permission_settings" => "all",
                "parent_id" => 9
            ],
            [
                "id" => 12,
                "permission_settings" => "all",
                "parent_id" => 9
            ],
            [
                "id" => 13,
                "permission_settings" => "all",
                "parent_id" => 9
            ]
        ];


        return $this->defineRole('Gerente de almacén', $warehouse_manager_config);
    }

    public function getChargeStoreManager()
    {
        $store_manager_config = [
            [
                "id" => 8,
                "permission_settings" => "all"
            ],
            [
                "id" => 9,
                "permission_settings" => "all"

            ],
            [
                "id" => 11,
                "permission_settings" => "all",
                "parent_id" => 9
            ],
            [
                "id" => 12,
                "permission_settings" => "all",
                "parent_id" => 9
            ],
            [
                "id" => 14,
                "permission_settings" => "all",
                "parent_id" => 9
            ]
        ];


        return $this->defineRole('Gerente de tienda', $store_manager_config);
    }

    public function getChargeJob()
    {
        $job_config = [
            [
                "id" => 8,
                "permission_settings" => "manual",
                "authorized" => true,
                "create" => false,
                "update" => true,
                "delete" => false
            ],
            [
                "id" => 9,
                "permission_settings" => "all"

            ],
            [
                "id" => 12,
                "permission_settings" => "manual",
                "parent_id" => 9,
                "authorized" => true,
                "create" => true,
                "update" => true,
                "delete" => false
            ],
            [
                "id" => 14,
                "permission_settings" => "manual",
                "parent_id" => 9,
                "authorized" => true,
                "create" => true,
                "update" => true,
                "delete" => false
            ],
            [
                "id" => 18,
                "permission_settings" => "manual",
                "authorized" => true,
                "create" => true,
                "update" => true,
                "delete" => false
            ],
        ];


        return $this->defineRole('Empleado', $job_config);
    }
}
