<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contabilidad extends Model
{
    protected $fillable = [
        'id_etapas', 'id_compra', 'id_fisica','nro_factura','fecha_emision','beneficiario', 'cuit','importe','cae','nro_pago','nombre_archivo_factura','nombre_archivo_comprobante_afip',
    ];
    public $timestamps  = true;

     // metodos

     public static function get_registro($id_etapas)
     {
        //  $row = self::find($id_etapas);
         $row = Contabilidad::where('id_etapas', '=', $id_etapas)->get();
         return $row;       
     }

     public static function get_registro_id_fisica($id_fisica)
     {
        //  $row = self::find($id_etapas);
         $row = Contabilidad::where('id_fisica', '=', $id_fisica)->first();
         return $row;       
     }
}
