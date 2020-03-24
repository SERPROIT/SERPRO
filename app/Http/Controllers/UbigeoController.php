<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use App\Http\Repositories\UbigeoRepository;



 class UbigeoController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */

    public function getDeparment()
    {        
          $oUbigeo = new UbigeoRepository();
          $n = $oUbigeo->getDeparment();                 
        return response()->json($n);
    }

    public function getProvince(Request $request)
    {        
        $oUbigeo = new UbigeoRepository();        
        $n = $oUbigeo->getProvince($request->id);        
        return response()->json($n);
    }

    public function getDistrict(Request $request)
    {        
        $oUbigeo = new UbigeoRepository();
        $n = $oUbigeo->getDistrict($request->idprovince, $request->iddepartment);        
        return response()->json($n);
    }
	
	/*
		N° : REQ_PIERR_1
		GESTION: PROVEEDOR
		AUTOR: PIERR GRIMALDO
		FECHA ACTUALIZADO: 2020-03-23
		FUNCION: ´ListarDistritoProveedor´ Listará el distrito de la vista proveedor.
				 ´ListarTipoServicio´ Listará el tipo de proveedor en la vista proveedor.
	*/
	
	
    public function ListarDistritoProveedor(Request $request)
    {
        $oUbigeo = new UbigeoRepository();
        $n = $oUbigeo->ListarDistritoProveedor($request->idprovince, $request->iddepartment);
        return response()->json($n);
    }

    public function ListarTipoServicio(Request $request)
    {
        $oUbigeo = new UbigeoRepository();
        $n = $oUbigeo->ListarTipoServicio();
        return response()->json($n);
    }

}