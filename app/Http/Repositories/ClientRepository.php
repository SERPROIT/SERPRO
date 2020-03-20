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

    public function getListPublicidad()
    {
        $publicidad = DB::select('select id, nombre from publicidad where estado = 1');
        
        return $publicidad;

    }

    public function getListTipoCliente()
    {
        $tipocliente = DB::select('select id, nombre from tipocliente where estado = 1');
        
        return $tipocliente;

    }

    public function saveClient($name, $iddepartment, $idprovince, $iddistrict, $addres, $phone, $fechaingreso, $idpublicidad, $programacionvisita, $idtipocliente, $status, $id){
         $client = DB::insert('insert into cliente (nombre,iddepartamento,idprovincia,iddistrito,direccion,telefono,fechaingreso, idpublicidad, programacionvisita, idtipocliente, estado) values (?,?,?,?,?,?,?,?,?,?,?)', [ $name, $iddepartment, $idprovince, $iddistrict, $addres, $phone, $fechaingreso, $idpublicidad, $programacionvisita, $idtipocliente, $status]);
        
        return $client;
    }

    public function updateClient($name, $iddepartment, $idprovince, $iddistrict, $addres, $phone, $fechaingreso, $idpublicidad, $programacionvisita, $idtipocliente, $status, $id){
         $client = DB::update('update cliente set nombre = ?, iddepartamento = ?, idprovincia = ?, iddistrito = ?, direccion = ?, telefono = ?, fechaingreso = ?, idpublicidad =?, programacionvisita = ?, idtipocliente = ?, estado = ?   where id = ?', [ $name, $iddepartment, $idprovince, $iddistrict, $addres, $phone, $fechaingreso, $idpublicidad, $programacionvisita, $idtipocliente, $status, $id]);
        
        return $client;
    }

    public function deleteClient($id){

         $client = DB::update('update cliente set estado = 0 where id = ?', [$id]);
        
        return $client;
    }

    public function onlyClient($id){
        
         $client = DB::select('select id,nombre,iddepartamento,idprovincia,iddistrito,direccion,telefono,DATE_FORMAT(fechaingreso, "%d/%m/%Y") as fechaingreso, idpublicidad, programacionvisita, idtipocliente from cliente where id = ?', [$id]);
        
        return $client;
    }
}