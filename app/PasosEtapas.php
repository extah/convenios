<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasosEtapas extends Model
{
    //
    protected $fillable = [
        'nombre_proyecto', 'paso1', 'paso2','paso3','paso4','finalizo', 'creado', 'tipo_rendicion',
    ];

    //metodos

    public static function get_registro($id)
    {
        $row = self::find($id);
        return $row;       
    }
    public static function get_registro_vector($id_etapas)
    {
       //  $row = self::find($id_etapas);
        $row = PasosEtapas::where('id', '=', $id_etapas)->get();
        return $row;       
    }
}
