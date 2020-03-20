<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Repositories\ClientRepository;


class ClientController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */

    // public function _construct(){
    //     $this->middleware('auth');
    // }


    public function index()
    { 

        if(!session('valido_session')){      
            return redirect()->action('UserController@index');
        }  
         session(['default'=>'CLIENTE']);     
        return view('cliente.cliente');           
    }

    public function getListClient(Request $request){

         $oCliente = new ClientRepository();

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');

        $search = $request->get('search')['value'];
        $order_dir = $request->get('order')[0]['dir'];
        $order_col = $request->get('order')[0]['column'];

        $members = $oCliente->getListClient($length,$start,$order_col,$order_dir,$search);

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

    public function saveClient(Request $request){
        $oUbigeo = new ClientRepository();
        //fechaingreso, idpublicidad, programacionvisita, idtipocliente,
          $n = $oUbigeo->saveClient($request->name, $request->iddepartment, $request->idprovince, $request->iddistrict, $request->addres, $request->phone, $request->fechaingreso, $request->idpublicidad, $request->programacionvisita, $request->idtipocliente, 1, $request->id);                 
        return response()->json($n);
    }

    public function updateClient(Request $request){
        $oUbigeo = new ClientRepository();
          $n = $oUbigeo->updateClient($request->name, $request->iddepartment, $request->idprovince, $request->iddistrict, $request->addres, $request->phone, $request->fechaingreso, $request->idpublicidad, $request->programacionvisita, $request->idtipocliente, 1, $request->id);                 
        return response()->json($n);
    }

    public function deleteClient(Request $request){
        $oUbigeo = new ClientRepository();
        $n = $oUbigeo->deleteClient($request->id);                 
        return response()->json($n);
    }

    public function onlyClient(Request $request){
        $oUbigeo = new ClientRepository();
        $n = $oUbigeo->onlyClient($request->id);                 
        return response()->json($n);
    
    }
    public function getListPublicidad(Request $request){
        $oPublicidad = new ClientRepository();
        $n = $oPublicidad->getListPublicidad();                 
        return response()->json($n);
    }

    public function getListTipoCliente(Request $request){
        $oTipoCliente = new ClientRepository();
        $n = $oTipoCliente->getListTipoCliente();                 
        return response()->json($n);
    }

}