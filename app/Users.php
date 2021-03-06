<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
        //
        protected $fillable = [
            'nombreyApellido', 'cuit', 'dni','contrasena',
        ];
    
        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'contrasena', 'remember_token',
        ];

        public static function get_registro($cuit)
        {
           //  $row = self::find($id_etapas);
            $row = Users::where('cuit', '=', $cuit)->first();
            return $row;       
        }
}
