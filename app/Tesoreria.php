<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tesoreria extends Model
{
    protected $fillable = [
        'id_etapas', 'id_compra', 'fecha_pago','nombre_archivo_pago',
    ];
    public $timestamps  = true;

     // metodos

     public static function get_registro($id_etapas)
     {
        //  $row = self::find($id_etapas);
         $row = Tesoreria::where('id_etapas', '=', $id_etapas)->get();
         return $row;       
     }
}
