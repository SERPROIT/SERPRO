<?php

namespace App\Http\Repositories;


use Illuminate\Support\Facades\DB;
 class UbigeoRepository 
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function getDeparment()
    {
        $departments = DB::select('select id,nombre from Departamento');
        return $departments;
    }

    public function getProvince($iddepartment)
    {
        $provinces = DB::select('select id,nombre from Provincia where iddepartamento = ?',[$iddepartment]);
        return $provinces;
    }

    public function getDistrict($idprovince, $iddepartment)
    {
        $districts = DB::select('select id,nombre from Distrito where idprovincia = ? and iddepartamento = ?', [ $idprovince, $iddepartment]);
        return $districts;
    }
	
	/*
		N° : REQ_PIERR_1
		GESTION: PROVEEDOR
		AUTOR: PIERR GRIMALDO
		FECHA ACTUALIZADO: 2020-03-23
		FUNCION: ´ListarDistritoProveedor´ Listará el distrito de la vista proveedor.
				 ´ListarTipoServicio´ Listará el tipo de proveedor en la vista proveedor.
	*/
	

    public function ListarDistritoProveedor($idprovince, $iddepartment )
    {
        try {
            $districts = DB::select('CALL sp_S_ListarDistritosProveedor(?,?)', [$idprovince, $iddepartment]);
            return $districts;
        }
        catch (MySQLDuplicateKeyException $e) {
            $e->getMessage();
        }
        catch (MySQLException $e) {
            $e->getMessage();
        }
        catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function ListarTipoServicio()
    {
        try {
            $lstTipoServicio = DB::select('CALL sp_S_ListarTipoServicioProveedor()');
            return $lstTipoServicio;
        }
        catch (MySQLDuplicateKeyException $e) {
            $e->getMessage();
        }
        catch (MySQLException $e) {
            $e->getMessage();
        }
        catch (Exception $e) {
            $e->getMessage();
        }
    }

}