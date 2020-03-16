<?php

namespace App\Http\Repositories;


use Illuminate\Support\Facades\DB;

class WorkerRepository 
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */


    public function getListWorker($DisplayLength,$DisplayStart,$SortCol,$SortDir,$Search)
    {
        $workers = DB::select('CALL sp_worker(?,?,?,?,?)',[$DisplayLength,$DisplayStart,$SortCol,$SortDir,$Search]);
        
        return $workers;

    }

    public function saveWorker($usuario, $password, $nombre, $dni, $correo, $telefono, $direccion, $vigencia){
        //usuario, password, nombres, dni, correo, telefono, direccion, vigencia
         $worker = DB::insert('insert into usuario (usuario, password, nombre, dni, correo, telefono, direccion, estado, vigencia) values (?,?,?,?,?,?,?,?,?)', [ $usuario, $password, $nombre, $dni, $correo, $telefono, $direccion, 1, $vigencia]);
        
        return $worker;
    }

    public function updateWorker($usuario, $password, $nombre, $dni, $correo, $telefono, $direccion, $vigencia, $id){
         $worker = DB::update('update usuario set usuario = ?, password = ?, nombre = ?, dni = ?, correo = ?, telefono = ?, direccion = ?, vigencia = ?  where id = ?', [ $usuario, $password, $nombre, $dni, $correo, $telefono, $direccion, $vigencia, $id]);
        
        return $worker;
    }

    public function deleteWorker($id){

         $worker = DB::update('update usuario set estado = 0 where id = ?', [$id]);
        
        return $worker;
    }

    public function onlyWorker($id){
        
         $worker = DB::select('select id,usuario, password, nombre, dni, correo, telefono, direccion, estado, vigencia from usuario where id = ?', [$id]);
        
        return $worker;
    }
}