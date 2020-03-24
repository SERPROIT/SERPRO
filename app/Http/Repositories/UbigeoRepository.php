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

    public function getProvince($iddepartment)
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


    #endregion

}
