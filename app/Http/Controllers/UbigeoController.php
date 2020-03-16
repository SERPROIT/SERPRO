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

}