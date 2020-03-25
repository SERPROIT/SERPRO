<?php

namespace App\Http\Repositories;


use Illuminate\Support\Facades\DB;

class ProveedorRepository
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function getListProveedor($DisplayLength,$DisplayStart,$SortCol,$SortDir,$Search)
    {
        $lsproveedor = DB::select('CALL sp_proveedor(?,?,?,?,?)',[$DisplayLength,$DisplayStart,$SortCol,$SortDir,$Search]);

        return $lsproveedor;

    }

    public function RegistrarNuevoProveedor($name, $iddepartamento, $idprovincia, $iddistrict, $idtiposervicio, $addres, $phone, $status){
       try {
        $oproveedor = DB::select('CALL sp_I_RegistrarNuevoProveedor(?,?,?,?,?,?,?,?)', [$name, $iddepartamento, $idprovincia, $iddistrict, $idtiposervicio, $addres, $phone, $status]);

        return $oproveedor;
       }
       catch (MySQLDuplicateKeyException $e) {
        $e->getMessage();
        }
        catch (MySQLException $e) {
            $e->getMessage();
        }
        catch (Exception $e) {
            $e->getMessage();
        }

    }

    public function updateProveedor($name, $iddepartamento, $idprovincia, $iddistrict, $idtiposervicio, $addres, $phone, $id){
        $opro = DB::update('update proveedor set nombre = ?, iddepartamento=?, idprovincia=?, iddistrito = ?, idtiposervicio= ?, direccion = ?, telefono = ?  where id = ?', [ $name, $iddepartamento, $idprovincia, $iddistrict, $idtiposervicio, $addres, $phone, $id]);

       return $opro;
   }

    public function deleteProveedor($id){

         $oproveedor = DB::update('update proveedor set estado = 0 where id = ?', [$id]);

        return $oproveedor;
    }

    public function onlyProveedor($id){

        $opro = DB::select('select id,nombre,iddepartamento,idprovincia,iddistrito,idtiposervicio,direccion,telefono from proveedor where id = ?', [$id]);

       return $opro;
   }

   //MANTENIMIENTO MODAL

   public function ListarRegistroServicioDt($DisplayLength,$DisplayStart,$SortCol,$SortDir,$Search)
   {
       try {
            $workers = DB::select('CALL sp_S_ListarServicioMantenimiento(?,?,?,?,?)',[$DisplayLength,$DisplayStart,$SortCol,$SortDir,$Search]);
            return $workers;
        }
        catch (MySQLDuplicateKeyException $e) {
            $e->getMessage();
        }
        catch (MySQLException $e) {
            $e->getMessage();
        }
        catch (Exception $e) {
            $e->getMessage();
        }
   }

   public function RegistrarServicioMantenimiento($servicio){
        //usuario, password, nombres, dni, correo, telefono, direccion, vigencia
        $cargo = DB::insert('insert into tiposervicio (nombre, estado) values (?, ?)', [ $servicio, 1]);

        return $cargo;
    }

    public function ActualizarServicioMantenimiento($servicio, $id){
        $cargo = DB::update('update tiposervicio set nombre = ? where id = ?', [ $servicio, $id ]);

       return $cargo;
   }

    public function EliminarSerivicioMantenimiento($id){

        $cargo = DB::update('update tiposervicio set estado = 0 where id = ?', [$id]);

        return $cargo;
    }

   public function OnlyProveedorMantenimiento($id){

        $tipoServicio = DB::select('select id, nombre from tiposervicio where id = ? and estado = 1', [$id]);

    return $tipoServicio;
    }

    public function BusquedaProveedorMantenimiento($servicio){

        $tipoServicio = DB::select('select id from tiposervicio where estado = 1 AND  nombre = ? ', [$servicio]);

       return $tipoServicio;
   }

   public function ListarTipoServicio()
    {
        try {
            $lstTipoServicio = DB::select('select id,nombre from tiposervicio');
            return $lstTipoServicio;
        }
        catch (MySQLDuplicateKeyException $e) {
            $e->getMessage();
        }
        catch (MySQLException $e) {
            $e->getMessage();
        }
        catch (Exception $e) {
            $e->getMessage();
        }
    }

}
