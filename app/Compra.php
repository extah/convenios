<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $fillable = [
        'id_etapas', 'orden_compra', 'nombre_archivo',
    ];
    public $timestamps  = true;

     // metodos

     public static function get_registro($id_etapas)
     {
        //  $row = self::find($id_etapas);
         $row = Compra::where('id_etapas', '=', $id_etapas)->first();
         return $row;       
     }
}
