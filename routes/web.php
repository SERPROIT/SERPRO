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

// Route::get('/navbar', function () {
//     return view('partial.navbar');
// });


Route::get('cliente', 'ClientController@index');
Route::get('proveedor', 'ProveedorController@index');
Route::get('worker', 'WorkerController@index');
Route::get('login', 'UserController@index');
Route::get('inicio', 'InicioController@index');



Route::get('cliente', 'ClientController@index')->name('cliente.index');
// Route::get('cliente', 'ClientController@index')->name('worker.index');
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

//RProveedor
// Route::post('proveedor/save', 'ProveedorController@saveProveedor')->name('proveedor.save');
// Route::post('proveedor/update', 'ProveedorController@updateClient')->name('proveedor.update');
// Route::get('proveedor/lista', 'ProveedorController@getListProveedor')->name('proveedor.list');
// Route::post('proveedor/delete', 'ProveedorController@deleteProveedor')->name('proveedor.delete');

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
Route::get('ubigeo/province', 'UbigeoController@getProvince')->name('ubigeo.province');
Route::get('ubigeo/district', 'UbigeoController@getDistrict')->name('ubigeo.district');

//RMarcaciones

// Route::get('asistencia', 'AsistenciaController@index');
// Route::post('asistencia/save', 'AsistenciaController@RegistrarMarcacionUsuario')->name('asistencia.save');

// // Route::get('asistencia/lista', 'AsistenciaController@getListProveedor')->name('asistencia.list');

// Route::post('asistencia/delete', 'AsistenciaController@deleteProveedor')->name('asistencia.delete');

// Route::get('asistencia/busqusuario', 'AsistenciaController@BusquedaUsuarioMarcacion')->name('asistencia.busqusuario');

// Route::get('asistencia/valuser', 'AsistenciaController@ValidarContrasenaUsuario')->name('asistencia.valuser');

// Route::get('asistencia/lista', 'AsistenciaController@HistorialMarcacionList')->name('asistencia.list');

//RProveedores
// Route::get('proveedor', 'ProveedorController@index');

// Route::post('proveedor/save', 'ProveedorController@saveProveedor')->name('proveedor.save');
// Route::get('proveedor/lista', 'ProveedorController@getListProveedor')->name('proveedor.list');
// Route::post('proveedor/delete', 'ProveedorController@deleteProveedor')->name('proveedor.delete');
// Route::get('proveedor/only', 'ProveedorController@onlyProveedor')->name('proveedor.only');
// Route::post('proveedor/update', 'ProveedorController@updateProveedor')->name('proveedor.update');

//===========INICIO VALIDADO - VIEW PROVEEDOR

Route::post('proveedor/save', 'ProveedorController@RegistroDatosProveedor')->name('proveedor.save');
Route::get('proveedor/lista', 'ProveedorController@getListProveedor')->name('proveedor.list');
Route::post('proveedor/delete', 'ProveedorController@deleteProveedor')->name('proveedor.delete');
Route::get('proveedor/only', 'ProveedorController@onlyProveedor')->name('proveedor.only');
Route::post('proveedor/update', 'ProveedorController@updateProveedor')->name('proveedor.update');


Route::get('proveedor/tiposervicio', 'ProveedorController@ListarTipoServicio')->name('proveedor.tiposervicio');


//MODAL MANTENIMIENTO PROVEEDOR
Route::post('proveedor/saveservicio', 'ProveedorController@RegistrarServicioMantenimiento')->name('proveedor.saveservicio');
Route::post('proveedor/updateservicio', 'ProveedorController@ActualizarServicioMantenimiento')->name('proveedor.updateservicio');
Route::get('proveedor/listservicio', 'ProveedorController@ListarRegistroServicioDt')->name('proveedor.listservicio');
Route::post('proveedor/deleteservicio', 'ProveedorController@EliminarSerivicioMantenimiento')->name('proveedor.deleteservicio');
Route::get('proveedor/onlpro', 'ProveedorController@OnlyProveedorMantenimiento')->name('proveedor.onlpro');
Route::get('proveedor/search', 'ProveedorController@BusquedaProveedorMantenimiento')->name('proveedor.search');
//===FIN MODAL

//==== FIN VALIDADO PROVEEDOR



/*
Route::get('user/{id}/{name?}', function ($id, $name=null) {
    //
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);
*/