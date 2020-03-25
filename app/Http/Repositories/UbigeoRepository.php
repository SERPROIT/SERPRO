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


    #region Funciones publicas
    public function getDeparment()
    {
        try{
            $departments = DB::select('select id,nombre from departamento');
            return $departments;
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

    public function getProvince($iddepartment)
    {
        try {
            $provinces = DB::select('select id,nombre from provincia where iddepartamento = ?',[$iddepartment]);
            return $provinces;
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

    public function getDistrict($idprovince, $iddepartment)
    {
        $districts = DB::select('select id,nombre from distrito where idprovincia = ? and iddepartamento = ?', [ $idprovince, $iddepartment]);
        return $districts;
    }


    //lista proveedor
    public function ListaDepartamentoProveedor()
    {
        try{
            $departments = DB::select('CALL sp_S_ListarDepartamento()');
            return $departments;
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

    public function ListaProvinciaProveedor($iddepartment)
    {
        try {
            $provinces = DB::select('CALL sp_S_ListarPronvinciaProveedor(?)',[$iddepartment]);
            return $provinces;
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
            $lstTipoServicio = DB::select('select id,nombre from tiposervicio');
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


    #endregion

}
