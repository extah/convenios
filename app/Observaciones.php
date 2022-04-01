<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observaciones extends Model
{
    // use HasFactory;

    public static function get_registro($id_etapas)
    {
       //  $row = self::find($id_etapas);
        $row = Observaciones::where('id_etapas', '=', $id_etapas)->get();
        return $row;       
    }
}
