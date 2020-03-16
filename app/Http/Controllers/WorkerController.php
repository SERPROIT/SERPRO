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

        $total_members = $members[0]->TotalCount; 

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_members,
            'recordsFiltered' => $total_members,
            'data' => $members,
        );
       
         return response()->json($data);
    }

    public function saveWorker(Request $request){
    // var_dump($request);
        $oUbigeo = new WorkerRepository();
        //usuario, password, nombres, dni, correo, telefono, direccion, vigencia
        $vigencia = 1;
         if($request->vigencia){ $vigencia = 1; }else{$vigencia = 0;}
          $n = $oUbigeo->saveWorker($request->usuario, $request->password, $request->nombres, $request->dni, $request->correo, $request->telefono, $request->direccion, $vigencia);                 
        return response()->json($n );
    }

    public function updateWorker(Request $request){
            //print_r($request->vigencia);
        $oUbigeo = new WorkerRepository();
        $vigencia = 1;
         if($request->vigencia){ $vigencia = 1; }else{$vigencia = 0;}
          $n = $oUbigeo->updateWorker($request->usuario, $request->password, $request->nombres, $request->dni, $request->correo, $request->telefono, $request->direccion, $vigencia, $request->id);                 
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


}