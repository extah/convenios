<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paso1 extends Model
{
   
    protected $fillable = [
        'id_etapas', 'organismo_financiador', 'nombre_proyecto','monto','cuenta_bancaria',
    ];
    public $timestamps  = true;

     // metodos

     public static function get_registro($id_etapas)
     {
         $row = self::find($id_etapas);
         return $row;       
     }


}
