<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Repositories\WorkerRepository;


class WorkerController extends Controller
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
        session(['default'=>'ADMINISTRADOR']);     
        return view('worker.worker');           
    }

    public function getListWorker(Request $request){

        $oWorker = new WorkerRepository();

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');

        $search = $request->get('search')['value'];
        $order_dir = $request->get('order')[0]['dir'];
        $order_col = $request->get('order')[0]['column'];

        $members = $oWorker->getListWorker($length,$start,$order_col,$order_dir,$search);

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

    public function getListCargo(Request $request){

        $oWorker = new WorkerRepository();

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');

        $search = $request->get('search')['value'];
        $order_dir = $request->get('order')[0]['dir'];
        $order_col = $request->get('order')[0]['column'];


        $members = $oWorker->getListCargo($length,$start,$order_col,$order_dir,$search);

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

    public function saveWorker(Request $request){
    
        $oWorker = new WorkerRepository();
        //usuario, password, nombres, dni, correo, telefono, direccion, vigencia
        $vigencia = 1;
         if($request->vigencia){ $vigencia = 1; }else{$vigencia = 0;}
          $n = $oWorker->saveWorker($request->usuario, $request->password, $request->nombres, $request->dni, $request->correo, $request->telefono, $request->direccion, $vigencia, $request->idcargo, $request->passwordmaestro);                 
        return response()->json($n);
    }

    public function saveCargo(Request $request){
        $oUbigeo = new WorkerRepository();
          $n = $oUbigeo->saveCargo($request->cargo);                 
        return response()->json($n);
    }

    public function updateWorker(Request $request){
            //print_r($request->vigencia);
        $oUbigeo = new WorkerRepository();
        $vigencia = 1;
         if($request->vigencia){ $vigencia = 1; }else{$vigencia = 0;}
          $n = $oUbigeo->updateWorker($request->usuario, $request->password, $request->nombres, $request->dni, $request->correo, $request->telefono, $request->direccion, $vigencia, $request->idcargo, $request->passwordmaestro, $request->id);                 
        return response()->json($n);
    }

    public function deleteWorker(Request $request){
        $oUbigeo = new WorkerRepository();
        $n = $oUbigeo->deleteWorker($request->id);                 
        return response()->json($n);
    }

   public function onlyWorker(Request $request){
        $oUbigeo = new WorkerRepository();
        $n = $oUbigeo->onlyWorker($request->id);                 
        return response()->json($n);
    } 

    public function searchWorker(Request $request){
        $oWorker = new WorkerRepository();
        $n = $oWorker->searchWorker($request->usuario);                 
        return response()->json($n);
    }

    public function searchCargo(Request $request){
        $oWorker = new WorkerRepository();
        $n = $oWorker->searchCargo($request->cargo);                 
        return response()->json($n);
    }

    public function getCargo()
    {        
          $oCargo = new WorkerRepository();
          $n = $oCargo->getCargo();                 
        return response()->json($n);
    }

    public function onlyCargo(Request $request){
        $oCargo = new WorkerRepository();
        $n = $oCargo->onlyCargo($request->id);                 
        return response()->json($n);
    }

    public function deleteCargo(Request $request){
        $oCargo = new WorkerRepository();
        $n = $oCargo->deleteCargo($request->id);                 
        return response()->json($n);
    }

    public function updateCargo(Request $request){
            
        $oCargo = new WorkerRepository();
          $n = $oCargo->updateCargo($request->cargo, $request->id);                 
        return response()->json($n);
    }

    public function getListMenu(){
        $oMenu = new WorkerRepository();
          $n = $oMenu->getListMenu();                 
        return response()->json($n);
    }

    public function getListMenuPermiso(Request $request){

        $oMenu = new WorkerRepository();
          $n = $oMenu->getListMenuPermiso($request->idusuario);                 
        return response()->json($n);
    }

    public function savePermiso(Request $request){

        $oMenu = new WorkerRepository();
          $n = $oMenu->savePermiso($request->idusuario, $request->idsubmenu, $request->estado);                 
        return response()->json($n);
    }

}