<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paso4 extends Model
{
    protected $fillable = [
        'id_etapas', 'condicion_rendicion', 'nombre_archivo',
    ];
    public $timestamps  = true;
    //
    public static function get_registro($id_etapas)
    {
       //  $row = self::find($id_etapas);
        $row = Paso4::where('id_etapas', '=', $id_etapas)->first();
        return $row;       
    }
}
