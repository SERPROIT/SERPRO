<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('principal');
});


Route::get('cliente', 'ClientController@index');

Route::get('worker', 'WorkerController@index');
Route::get('login', 'UserController@index');
Route::get('inicio', 'InicioController@index');
Route::get('cliente', 'ClientController@index')->name('cliente.index');
Route::get('user/cerrar', 'UserController@closeSession');

Route::post('client/save', 'ClientController@saveClient')->name('client.save');
Route::post('client/update', 'ClientController@updateClient')->name('client.update');
Route::get('client/lista', 'ClientController@getListClient')->name('client.list');
Route::post('client/delete', 'ClientController@deleteClient')->name('client.delete');
Route::get('client/only', 'ClientController@onlyClient')->name('client.only');
Route::get('publicidad/lista', 'ClientController@getListPublicidad')->name('publicidad.list');
Route::get('tipocliente/lista', 'ClientController@getListTipoCliente')->name('tipocliente.list');


Route::post('worker/save', 'WorkerController@saveWorker')->name('worker.save');
Route::post('worker/update', 'WorkerController@updateWorker')->name('worker.update');
Route::get('worker/lista', 'WorkerController@getListWorker')->name('worker.list');
Route::post('worker/delete', 'WorkerController@deleteWorker')->name('worker.delete');
Route::get('worker/only', 'WorkerController@onlyWorker')->name('worker.only');
Route::get('worker/search', 'WorkerController@searchWorker')->name('worker.search');


Route::get('user/validate', 'UserController@validateUser')->name('user.validate');

Route::get('permiso/menu', 'WorkerController@getListMenu');
Route::get('permiso/permiso', 'WorkerController@getListMenuPermiso');
Route::post('permiso/registrar', 'WorkerController@savePermiso')->name('permiso.save');
//
Route::get('cargo/cargo', 'WorkerController@getCargo');
Route::post('cargo/save', 'WorkerController@saveCargo')->name('cargo.save');
Route::post('cargo/update', 'WorkerController@updateCargo')->name('cargo.update');
Route::get('cargo/lista', 'WorkerController@getListCargo')->name('cargo.list');
Route::post('cargo/delete', 'WorkerController@deleteCargo')->name('cargo.delete');
Route::get('cargo/only', 'WorkerController@onlyCargo')->name('cargo.only');
Route::get('cargo/search', 'WorkerController@searchCargo')->name('cargo.search');

Route::get('ubigeo/deparment', 'UbigeoController@getDeparment');

//UBIGEO LISTADOS
Route::get('ubigeo/deparment', 'UbigeoController@getDeparment')->name('ubigeo.deparment');;

Route::get('ubigeo/province', 'UbigeoController@getProvince')->name('ubigeo.province');

Route::get('ubigeo/district', 'UbigeoController@getDistrict')->name('ubigeo.district');

//LISTAS PRONVINCIA - DEPARTAMENTO - DISTRITO
Route::get('ubigeo/lstdeparment', 'UbigeoController@ListaDepartamentoProveedor')->name('ubigeo.lstdeparment');;

Route::get('ubigeo/lstprovince', 'UbigeoController@ListaProvinciaProveedor')->name('ubigeo.lstprovince');

Route::get('ubigeo/districtproveedor', 'UbigeoController@ListarDistritoProveedor')->name('ubigeo.districtproveedor');

Route::get('ubigeo/tiposervicio', 'UbigeoController@ListarTipoServicio')->name('ubigeo.tiposervicio');;


//===========INICIO VALIDADO - VIEW PROVEEDOR
Route::get('proveedor', 'ProveedorController@index');

Route::post('proveedor/save', 'ProveedorController@RegistroDatosProveedor')->name('proveedor.save');

Route::get('proveedor/lista', 'ProveedorController@getListProveedor')->name('proveedor.list');

Route::post('proveedor/delete', 'ProveedorController@deleteProveedor')->name('proveedor.delete');

Route::get('proveedor/only', 'ProveedorController@onlyProveedor')->name('proveedor.only');

Route::post('proveedor/update', 'ProveedorController@updateProveedor')->name('proveedor.update');

//MODAL MANTENIMIENTO PROVEEDOR
Route::post('proveedor/saveservicio', 'ProveedorController@RegistrarServicioMantenimiento')->name('proveedor.saveservicio');

Route::post('proveedor/updateservicio', 'ProveedorController@ActualizarServicioMantenimiento')->name('proveedor.updateservicio');

Route::get('proveedor/listservicio', 'ProveedorController@ListarRegistroServicioDt')->name('proveedor.listservicio');

Route::post('proveedor/deleteservicio', 'ProveedorController@EliminarSerivicioMantenimiento')->name('proveedor.deleteservicio');

Route::get('proveedor/onlpro', 'ProveedorController@OnlyProveedorMantenimiento')->name('proveedor.onlpro');

Route::get('proveedor/search', 'ProveedorController@BusquedaProveedorMantenimiento')->name('proveedor.search');
//===FIN MODAL

//==== FIN VALIDADO PROVEEDOR
