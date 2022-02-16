<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fisica_obra extends Model
{
    protected $fillable = [
        'id_etapas', 'compra', 'nro_certificado','procentaje','monto', 'nombre_archivo',
    ];
    public $timestamps  = true;

     // metodos

     public static function get_registro($id_etapas)
     {
        //  $row = self::find($id_etapas);
         $row = Paso1::where('id_etapas', '=', $id_etapas)->get();
         return $row;       
     }
}
