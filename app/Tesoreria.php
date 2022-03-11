<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tesoreria extends Model
{
    protected $fillable = [
        'id_etapas', 'id_compra', 'id_contabilidad', 'fecha_pago','nombre_archivo_pago',
    ];
    public $timestamps  = true;

     // metodos

     public static function get_registro($id_etapas)
     {
        //  $row = self::find($id_etapas);
         $row = Tesoreria::where('id_etapas', '=', $id_etapas)->get();
         return $row;       
     }
     public static function get_registro_id_contabilidad($id_contabilidad)
     {
        //  $row = self::find($id_etapas);
         $row = Tesoreria::where('id_contabilidad', '=', $id_contabilidad)->first();
         return $row;       
     }
}
