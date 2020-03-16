<?php

namespace App\Http\Repositories;


use Illuminate\Support\Facades\DB;

class ProveedorRepository
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function getListProveedor($DisplayLength,$DisplayStart,$SortCol,$SortDir,$Search)
    {
        $lsproveedor = DB::select('CALL sp_proveedor(?,?,?,?,?)',[$DisplayLength,$DisplayStart,$SortCol,$SortDir,$Search]);

        return $lsproveedor;

    }

    public function saveProveedor($name, $iddepartment, $idprovince, $iddistrict, $addres, $phone, $status, $id){
         $oproveedor = DB::insert('insert into proveedor (nombre,idtipoproveedor,iddepartamento,idprovincia,iddistrito,direccion,telefono,estado) values (?,?,?,?,?,?,?,?)', [ $name, 1,$iddepartment, $idprovince, $iddistrict, $addres, $phone, $status]);

        return $oproveedor;
    }

    public function updateProveedor($name, $iddepartment, $idprovince, $iddistrict, $addres, $phone, $status, $id){
        $opro = DB::update('update proveedor set nombre = ?, iddepartamento = ?, idprovincia = ?, iddistrito = ?, direccion = ?, telefono = ?, estado = ?  where id = ?', [ $name, $iddepartment, $idprovince, $iddistrict, $addres, $phone, $status, $id]);

       return $opro;
   }

    public function deleteProveedor($id){

         $oproveedor = DB::update('update proveedor set estado = 0 where id = ?', [$id]);

        return $oproveedor;
    }

    public function onlyProveedor($id){

        $opro = DB::select('select id,nombre,idtipoproveedor,iddepartamento,idprovincia,iddistrito,direccion,telefono from proveedor where id = ?', [$id]);

       return $opro;
   }
}
