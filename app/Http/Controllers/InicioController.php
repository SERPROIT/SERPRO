<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;



class InicioController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function index(Request $request)
    {       
  
        if(session('valido_session')){
            session(['default'=>'INICIO']);
            return view('inicio.inicio');  
        }else{
            return redirect()->action('UserController@index');      
        }
                   
    }
}