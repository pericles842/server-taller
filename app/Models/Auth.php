<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Authorization
{
    public $template = '{
       "usuarios": {
           "id": 1,
           "label": "Usuarios",
           "authorized": true,
           "create": true,
           "update": true,
           "delete": true
       },
       "monedas": {
           "id": 2,
           "label": "Monedas",
           "authorized": true,
           "create": true,
           "update": true,
           "delete": true
       },
       "cargos": {
           "id": 3,
           "label": "Cargos",
           "authorized": true,
           "create": true,
           "update": true,
           "delete": true
       },
       "tiendas": {
           "id": 4,
           "label": "Tiendas",
           "authorized": true,
           "create": true,
           "update": true,
           "delete": true
       },
       "almacenes": {
           "id": 5,
           "label": "Almacenes",
           "authorized": true,
           "create": true,
           "update": true,
           "delete": true
       },
       "sucursales": {
           "id": 6,
           "label": "Sucursales",
           "authorized": true,
           "create": true,
           "update": true,
           "delete": true
       },
       "productos": {
           "id": 7,
           "label": "Productos",
           "authorized": true,
           "create": true,
           "update": true,
           "delete": true
       },
       "inventario": {
           "id": 8,
           "label": "Inventario",
           "authorized": true,
           "create": true,
           "update": true,
           "delete": true
       },
       "notas": {
           "id": 9,
           "label": "Notas",
           "authorized": true,
           "entrega": {
               "id": 10,
               "label": "Entrega",
               "authorized": true,
               "create": true,
               "update": true,
               "delete": true
           },
           "movimiento": {
               "id": 11,
               "label": "Movimiento",
               "authorized": true,
               "create": true,
               "update": true,
               "delete": true
           },
           "devolucion": {
               "id": 12,
               "label": "Devolución",
               "authorized": true,
               "create": true,
               "update": true,
               "delete": true
           },
           "salida": {
               "id": 13,
               "label": "Salida",
               "authorized": true,
               "create": true,
               "update": true,
               "delete": true
           },
           "venta": {
               "id": 14,
               "label": "Inventario",
               "authorized": true,
               "create": true,
               "update": true,
               "delete": true
           }
       },
       "reportes": {
           "id": 15,
           "label": "Reportes",
           "authorized": true,
           "create": true,
           "update": true,
           "delete": true
       }
    }';
}
