<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Repositories\UserRepository;


class UserController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function index(Request $request)
    {       
       // $valido = $request->session()->get('valido_session', 'true');
       // return view('usuario.usuario',compact('valido')); 
        //session(['valido_session' => false]);
      
        if(session('valido_session')){
            //return app('App\Http\Controllers\ClientController')->index();
            return redirect()->action('InicioController@index');
        }else{

            return view('usuario.usuario');      
        }
                   
    }


    public function validateUser(Request $request){
      
        $oUbigeo = new UserRepository();
        $user = $oUbigeo->validateUser($request->usuario, $request->password); 
        $listaMenu = $oUbigeo->menuUSer($user[0]->id);
                 
        if($user != null){
           session(['valido_session' => true]);
           session(['user' => $user[0]->usuario]);
           session(['menu' => $listaMenu]);
           session(['default' => $listaMenu[0]->ruta]);
        }

        return response()->json($user);                     
    }

    public function closeSession(){
           session(['valido_session' => false]);
           session(['user' => null]);  
          return redirect()->action('UserController@index');
    }

}