<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\ProveedorRepository;

class ProveedorController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function index()
    {
        return view('proveedor.proveedor');
    }

    public function getListProveedor(Request $request){

        $oProveedor = new ProveedorRepository();

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');

        $search = $request->get('search')['value'];
        $order_dir = $request->get('order')[0]['dir'];
        $order_col = $request->get('order')[0]['column'];

        $members = $oProveedor->getListProveedor($length,$start,$order_col,$order_dir,$search);

        $total_members = $members[0]->TotalCount;

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_members,
            'recordsFiltered' => $total_members,
            'data' => $members,
        );

        return response()->json($data);
    }

    public function saveProveedor(Request $request){
        $oUbigeo = new ProveedorRepository();
          $n = $oUbigeo->saveProveedor($request->name, $request->iddepartment, $request->idprovince, $request->iddistrict, $request->addres, $request->phone, 1, $request->id);
        return response()->json($n);
    }

    public function updateProveedor(Request $request)
    {
        $oUbigeo = new ProveedorRepository();
        $n = $oUbigeo->updateProveedor($request->name, $request->iddepartment, $request->idprovince, $request->iddistrict, $request->addres, $request->phone, 1,$request->id);
      return response()->json($n);
    }

    public function deleteProveedor(Request $request){
        $oUbigeo = new ProveedorRepository();
        $n = $oUbigeo->deleteProveedor($request->id);
        return response()->json($request->id);
    }

    public function onlyProveedor(Request $request){
        $oUbigeo = new ProveedorRepository();
        $n = $oUbigeo->onlyProveedor($request->id);
        return response()->json($n);
    }
}
