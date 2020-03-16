<?php

namespace App\Http\Repositories;


use Illuminate\Support\Facades\DB;

class ClientRepository 
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function getListClient($DisplayLength,$DisplayStart,$SortCol,$SortDir,$Search)
    {
        $clientes = DB::select('CALL sp_cliente(?,?,?,?,?)',[$DisplayLength,$DisplayStart,$SortCol,$SortDir,$Search]);
        
        return $clientes;

    }

    public function saveClient($name, $iddepartment, $idprovince, $iddistrict, $addres, $phone, $status, $id){
         $client = DB::insert('insert into cliente (nombre,iddepartamento,idprovincia,iddistrito,direccion,telefono,estado) values (?,?,?,?,?,?,?)', [ $name, $iddepartment, $idprovince, $iddistrict, $addres, $phone, $status]);
        
        return $client;
    }

    public function updateClient($name, $iddepartment, $idprovince, $iddistrict, $addres, $phone, $status, $id){
         $client = DB::update('update cliente set nombre = ?, iddepartamento = ?, idprovincia = ?, iddistrito = ?, direccion = ?, telefono = ?, estado = ?  where id = ?', [ $name, $iddepartment, $idprovince, $iddistrict, $addres, $phone, $status, $id]);
        
        return $client;
    }

    public function deleteClient($id){

         $client = DB::update('update cliente set estado = 0 where id = ?', [$id]);
        
        return $client;
    }

    public function onlyClient($id){
        
         $client = DB::select('select id,nombre,iddepartamento,idprovincia,iddistrito,direccion,telefono from cliente where id = ?', [$id]);
        
        return $client;
    }
}