<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasosEtapas extends Model
{
    //
    protected $fillable = [
        'nombre_proyecto', 'paso1', 'paso2','paso3','paso4','finalizo',
    ];

    //metodos

    public static function get_registro($id)
    {
        $row = self::find($id);
        return $row;       
    }
}
