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

    public function getListCargo($DisplayLength,$DisplayStart,$SortCol,$SortDir,$Search)
    {
        $workers = DB::select('CALL sp_cargo(?,?,?,?,?)',[$DisplayLength,$DisplayStart,$SortCol,$SortDir,$Search]);
        
        return $workers;

    }

    public function saveWorker($usuario, $password, $nombre, $dni, $correo, $telefono, $direccion, $vigencia, $idcargo, $passwordmaestro){
        
         $worker = DB::insert('insert into usuario (usuario, password, nombre, dni, correo, telefono, direccion, estado, vigencia, idcargo, passwordmaestro) values (?,?,?,?,?,?,?,?,?,?,?)', [ $usuario, $password, $nombre, $dni, $correo, $telefono, $direccion, 1, $vigencia, $idcargo, $passwordmaestro]);

         DB::insert('insert into permiso (idusuario, idsubmenu, estado) values ( (SELECT id FROM usuario ORDER BY id DESC LIMIT 1),4,1)');
        
        return $worker;
    }

    public function saveCargo($cargo){
        //usuario, password, nombres, dni, correo, telefono, direccion, vigencia
         $cargo = DB::insert('insert into cargo (nombre, estado) values (?,?)', [ $cargo, 1]);
        
        return $cargo;
    }

    public function updateWorker($usuario, $password, $nombre, $dni, $correo, $telefono, $direccion, $vigencia, $idcargo, $passwordmaestro, $id){
         $worker = DB::update('update usuario set usuario = ?, password = ?, nombre = ?, dni = ?, correo = ?, telefono = ?, direccion = ?, vigencia = ?, idcargo = ?, passwordmaestro = ?  where id = ?', [ $usuario, $password, $nombre, $dni, $correo, $telefono, $direccion, $vigencia, $idcargo, $passwordmaestro, $id]);
        
        return $worker;
    }

    public function deleteWorker($id){

         $worker = DB::update('update usuario set estado = 0 where id = ?', [$id]);
        
        return $worker;
    }

    public function searchWorker($usuario){

         $worker = DB::select('select id from usuario where estado = 1 AND  usuario = ? ', [$usuario]);
        
        return $worker;
    }

    public function searchCargo($cargo){

         $worker = DB::select('select id from cargo where estado = 1 AND  nombre = ? ', [$cargo]);
        
        return $worker;
    }

    public function onlyWorker($id){
        
         $worker = DB::select('select id,usuario, password, nombre, dni, correo, telefono, direccion, estado, vigencia, idcargo, passwordmaestro from usuario where id = ?', [$id]);
        
        return $worker;
    }

    public function getCargo()
    {
        $cargo = DB::select('select id,nombre from cargo where estado = 1');
        return $cargo;
    }

    public function onlyCargo($id){
        
         $cargo = DB::select('select id, nombre from cargo where id = ? and estado = 1', [$id]);
        
        return $cargo;
    }

    public function deleteCargo($id){

         $cargo = DB::update('update cargo set estado = 0 where id = ?', [$id]);
        
        return $cargo;
    }

    public function updateCargo($nombre, $id){
         $cargo = DB::update('update cargo set nombre = ? where id = ?', [ $nombre, $id]);
        
        return $cargo;
    }

    public function getListMenu()
    {
        $cargo = DB::select('select sb.id as idsubmenu, m.nombre as menu, sb.nombre as submenu from menu m inner join submenu sb on sb.idmenu = m.id where sb.estado = 1 and sb.nombre != "INICIO"');
        return $cargo;
    }

    public function getListMenuPermiso($idusuario)
    {
        $cargo = DB::select('select m.nombre as menu, sb.nombre as submenu, p.id as idpermiso, sb.id as idsubmenu from menu m 
            inner join submenu sb on sb.idmenu = m.id 
            left join permiso p on p.idsubmenu = sb.id
            where p.idusuario = ? and p.estado = 1', [$idusuario]);
        return $cargo;
    }

    public function savePermiso($idusuario,$idsubmenu,$estado)
    {
        $permiso = DB::select('CALL sp_permiso(?,?,?)',[$idusuario,$idsubmenu,$estado]);
        
        return $permiso;

    }

}