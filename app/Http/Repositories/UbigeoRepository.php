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

    

}