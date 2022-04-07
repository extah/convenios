<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fisica_producto_entregado extends Model
{
    public static function get_registro($id_etapas)
    {
       //  $row = self::find($id_etapas);
        $row = Fisica_producto_entregado::where('id_etapas', '=', $id_etapas)->get();
        return $row;       
    }

    public static function get_registro_id_compra($id_compra)
    {
       //  $row = self::find($id_etapas);
        $row = Fisica_producto_entregado::where('id_compra', '=', $id_compra)->get();
        return $row;       
    }
}
