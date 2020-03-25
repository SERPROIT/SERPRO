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

        if(!session('valido_session')){
            return redirect()->action('UserController@index');
        }
         session(['default'=>'PROVEEDOR']);
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



        if($members == null){
            $total_members = 0;
        }else{
            $total_members = $members[0]->TotalCount;
        }

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_members,
            'recordsFiltered' => $total_members,
            'data' => $members,
        );

        return response()->json($data);
    }

    public function RegistroDatosProveedor(Request $request){
        $oUbigeo = new ProveedorRepository();
          $n = $oUbigeo->RegistrarNuevoProveedor($request->name, $request->iddepartamento, $request->idprovincia, $request->iddistrict, $request->idtiposervicio, $request->addres, $request->phone, $request->status);
        return response()->json($n);
    }

    public function updateProveedor(Request $request)
    {
        $oUbigeo = new ProveedorRepository();
        $n = $oUbigeo->updateProveedor($request->name, $request->iddepartamento, $request->idprovincia, $request->iddistrict, $request->idtiposervicio, $request->addres, $request->phone, $request->id);
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

    //MODAL MANTENIMIENTO
    public function ListarRegistroServicioDt(Request $request){
    try {
            $oWorker = new ProveedorRepository();

            $draw = $request->get('draw');
            $start = $request->get('start');
            $length = $request->get('length');

            $search = $request->get('search')['value'];
            $order_dir = $request->get('order')[0]['dir'];
            $order_col = $request->get('order')[0]['column'];


            $members = $oWorker->ListarRegistroServicioDt($length,$start,$order_col,$order_dir,$search);

            if($members == null){
                $total_members = 0;
            }else{
                $total_members = $members[0]->TotalCount;
            }

            $data = array(
                'draw' => $draw,
                'recordsTotal' => $total_members,
                'recordsFiltered' => $total_members,
                'data' => $members,
            );

            return response()->json($data);
        }
        catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function RegistrarServicioMantenimiento(Request $request){
        $oUbigeo = new ProveedorRepository();
          $n = $oUbigeo->RegistrarServicioMantenimiento($request->servicio);
        return response()->json($n);
    }

    public function BusquedaProveedorMantenimiento(Request $request){
        $oWorker = new ProveedorRepository();
        $n = $oWorker->BusquedaProveedorMantenimiento($request->servicio);
        return response()->json($n);
    }

    public function OnlyProveedorMantenimiento(Request $request){
        $oCargo = new ProveedorRepository();
        $n = $oCargo->OnlyProveedorMantenimiento($request->id);
        return response()->json($n);
    }

    public function EliminarSerivicioMantenimiento(Request $request){
        $oCargo = new ProveedorRepository();
        $n = $oCargo->EliminarSerivicioMantenimiento($request->id);
        return response()->json($n);
    }

    public function ActualizarServicioMantenimiento(Request $request){

        $oCargo = new ProveedorRepository();
          $n = $oCargo->ActualizarServicioMantenimiento($request->servicio, $request->id);
        return response()->json($n);
    }

    public function ListarTipoServicio(Request $request)
    {
        $oUbigeo = new ProveedorRepository();
        $n = $oUbigeo->ListarTipoServicio();
        return response()->json($n);
    }
}
