<?php

namespace App\Http\Repositories;


use Illuminate\Support\Facades\DB;

class UserRepository 
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function validateUser($usuario,$password)
    {
        $usuario = DB::select('select id,usuario, password, nombre, correo, telefono, direccion, vigencia from usuario where usuario = ? and password = ? and estado = 1 and vigencia =1 ',[$usuario,$password]); 
             
        return $usuario;

    }

    public function menuUSer($idusuario){
        $listaMenu = DB::select('select m.nombre as menu, sm.nombre as submenu, sm.ruta FROM MENU m 
            INNER JOIN submenu sm ON m.id = sm.idmenu
            INNER JOIN permiso p ON p.idsubmenu = sm.id
            WHERE sm.estado = 1 AND p.estado = 1 AND m.estado = 1 AND p.idusuario = ?  ORDER BY m.nombre, sm.nombre  ASC',[$idusuario]); 
             
        return $listaMenu;
    }

}