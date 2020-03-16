@extends('principal')

@section('scripts')
    <script src="{{asset('js/global_assets/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/tables/datatables/extensions/fixed_columns.min.js')}}"></script>

    <script src="{{asset('js/global_assets/plugins/extensions/jquery_ui/interactions.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('js/global_assets/demo_pages/form_select2.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.4/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.4/sweetalert2.min.css">

    <script src="{{asset('js/global_assets/demo_pages/datatables_extension_fixed_columns.js')}}"></script>
@stop

@section('content')
<div class="content">
    <div class="card" >

        <div class="card-body" id="cardFormularioProveedor" style="display: none">
            <input type="hidden" value="" id="accion">
            <input type="hidden" value="" id="id">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">REGISTRO DE NUEVO PROVEEDOR</legend>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">NOMBRES</label>
                        <div class="col-lg-10">
                            <input type="text" name="nombres" class="form-control" placeholder="Ingresar Nombres">
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label class="col-form-label col-lg-2">TIPO PROVEEDOR</label>
                        <div class="col-lg-10">
                            <select id="cmbTipoProveedor"  data-placeholder="TipoProveedor" class="form-control select-search" data-fouc>
                             </select>
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">DEPARTAMENTO</label>
                        <div class="col-lg-10">
                            <select id="cmbDepartamento"  data-placeholder="Departamento" class="form-control select-search" data-fouc>
                             </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">PROVINCIA</label>
                        <div class="col-lg-10">
                            <select id="cmbProvincia"  data-placeholder="Provincia" class="form-control select-search" data-fouc>
                             </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">DISTRITO</label>
                        <div class="col-lg-10">
                            <select id="cmbDistrito"  data-placeholder="Distrito" class="form-control select-search" data-fouc>
                             </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">TELEFONO</label>
                        <div class="col-lg-10">
                            <input type="text" name="telefono" class="form-control" maxlength="15" placeholder="Ingresar Telefono">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">DIRECCION</label>
                        <div class="col-lg-10">
                            <textarea rows="3" cols="3" name="direccion" class="form-control" placeholder="Ingresar Direccion"></textarea>
                        </div>
                    </div>
                </fieldset>

                <div class="text-right">
                    <button type="submit" name="guardar" class="btn btn-primary">Guardar <i class="icon-paperplane ml-2"></i></button>
                    <button type="submit" name="cancelar" class="btn btn-secondary">Cancelar <i class="icon-paperplane ml-2"></i></button>
                </div>

        </div>
        <div class="card-body" id="cardAgregarProveedor">
            <div class="text-left">
                <button type="submit" name="agregar" class="btn btn-primary">Agregar Nuevo Proveedor <i class="icon-file-plus ml-2"></i></button>
            </div>
        </div>
    </div>


    <!-- Multiple fixed columns -->
    <div class="card">
        <table id="tblProveedor" class="table" width="100%">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Departamento</th>
                    <th>Provincia</th>
                    <th>Distrito</th>
                    <th>Telefono</th>
                    <th>Direccion</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <!-- /multiple fixed columns -->
</div>
<script>

    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      var _tblProveedor =  $('#tblProveedor').DataTable({
            scrollX: true,
            scrollY: '350px',
            scrollCollapse: true,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{  route('proveedor.list') }}",
                "type": "GET",
                "datatype": 'JSON',
            },
            columns: [
                { "data": "nombre" },
                { "data": "iddepartamento" },
                { "data": "idprovincia" },
                { "data": "iddistrito" },
                { "data": "telefono" },
                { "data": "direccion" },
                {
                   "data": 'id',
                   "render": function (id) {
                        var btnEliminar = "<button type='button' name="+id+" class='btn btn-danger rounded-round'><i class='icon-bin'></i></button>";
                        var btnActulizar = "<button type='button' name="+id+" class='btn btn-primary rounded-round'><i class='icon-compose'></i></button>";
                       return btnEliminar+" "+btnActulizar;
                   }
                }
            ],
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            language: {
                "searchPlaceholder": "Busqueda ...",
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar: ",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });

        $("button[name=guardar]").click(function(){
            //#region  Validaciones de Controles
            var _S_INPUT_VACIO ="";
            var _S_INGRESO_NOMBRE_PROVEEDOR = "Favor de ingresar un nombre.";
            var _S_INGRESO_DEPARTAMENTO_PROVEEDOR = "Favor de seleccionar un Departamento.";
            var _S_INGRESO_PROVINCIA_PROVEEDOR = "Favor de seleccionar una Provincia.";
            var _S_INGRESO_DISTRITO_PROVEEDOR = "Favor de seleccionar un Distrito.";
            var _S_INGRESO_TELEFONO_PROVEEDOR = "Favor de ingresar un telefono.";
            var _S_INGRESO_DIRECCION_PROVEEDOR = "Favor de ingresar un direccion.";
            //#endregion
            var accion = $("#accion").val()
            var id = $("#id").val()
            var nombres = $("input[name=nombres]").val()
            var departamento = $("#cmbDepartamento").val()
            var provincia = $("#cmbProvincia").val()
            var distrito = $("#cmbDistrito").val()
            var telefono = $("input[name=telefono]").val()
            var direccion = $("textarea[name=direccion]").val()

            var objproveedor = {name:nombres, iddepartment:departamento, idprovince:provincia, iddistrict:distrito, addres:direccion, phone:telefono, id:id}

            if($("input[name=nombres]").val() == _S_INPUT_VACIO){

            swal ("Oops!" , " " + _S_INGRESO_NOMBRE_PROVEEDOR + " ", "error")

            }else if (departamento == _S_INPUT_VACIO){
                swal ( "Oops!" , "" + _S_INGRESO_DEPARTAMENTO_PROVEEDOR + "" ,  "error" )
            }else if(provincia == _S_INPUT_VACIO){
                swal ( "Oops!" , "" + _S_INGRESO_PROVINCIA_PROVEEDOR + "",  "error" )
            }else if(distrito == _S_INPUT_VACIO){
                swal ( "Oops!" , "" + _S_INGRESO_DISTRITO_PROVEEDOR + "",  "error" )
            }else if(telefono == _S_INPUT_VACIO){
                swal ( "Oops!" , "" + _S_INGRESO_TELEFONO_PROVEEDOR + "",  "error" )
            }else if(direccion == _S_INPUT_VACIO){
                swal ( "Oops!" , "" + _S_INGRESO_DIRECCION_PROVEEDOR + "",  "error" )
            }else{
                if(accion == "registrar"){
                RegistrarProveedor(objproveedor)
                }else if(accion == "modificar"){
                    ModificarProveedor(objproveedor)
                }
            }

            $("#cardFormularioProveedor").css("display", "none")
            $("#cardAgregarProveedor").css("display", "inline")
            LimpiarFormulario();

        });

        $('#tblProveedor tbody').on( 'click','button.btn-danger', function () {
             var id = $(this)[0].name
             console.log(id)
             EliminarProveedor(id)
        });

        $('#tblProveedor tbody').on( 'click','button.btn-primary', function () {
             var id = $(this)[0].name
             ObtenerProveedor(id)
             $("#cardFormularioProveedor").css("display", "inline")
             $("#cardAgregarProveedor").css("display", "none")
        });

        $("button[name=agregar]").click(function(){
            $("#accion").val("registrar")
             $("#cardFormularioProveedor").css("display", "inline")
             $("#cardAgregarProveedor").css("display", "none")
        });

        $("button[name=cancelar]").click(function(){
            LimpiarFormulario()
             $("#cardFormularioProveedor").css("display", "none")
             $("#cardAgregarProveedor").css("display", "inline")
        });

        // $.ajax({
        //     type: 'GET',
        //     url: "{{ URL::to('ubigeo/tproveedor')}}",
        //     datatype: 'JSON',
        //     success:function(data){
        //         var lista = [];
        //         $.each(data, function (i, data) {
        //             var option = {id:data.id,text:data.nombre}
        //             lista[i] = option
        //         });
        //         $('#cmbTipoProveedor').select2({ data: lista });
        //     },
        //     error:function(data){
        //         console.log(data);
        //     }
        // });

        $.ajax({
            type: 'GET',
            url: "{{ URL::to('ubigeo/deparment')}}",
            datatype: 'JSON',
            success:function(data){

                var lista = [];

                $.each(data, function (i, data) {

                    var option = {id:data.id,text:data.nombre}

                    lista[i] = option

                });

                $('#cmbDepartamento').select2({ data: lista });
                getProvince($('#cmbDepartamento').val());
            },
            error:function(data){
                console.log(data);
            }
        });



        $('#cmbDepartamento').on('change', function() {

          getProvince($(this).val())

        });

        $('#cmbProvincia').on('change', function() {

          getDistrict($(this).val(),$('#cmbDepartamento').val())

        });

        function getProvince(id){

            $.ajax({
                url: "{{  route('ubigeo.province') }}",
                type: 'GET',
                data: { 'id':id},
                datatype: 'JSON',
                success:function(data){

                        var lista = [];

                        $.each(data, function (i, data) {

                            var option = {id:data.id,text:data.nombre}

                            lista[i] = option

                        });
                        $('#cmbProvincia').empty();
                        $('#cmbProvincia').select2({ data: lista });
                        getDistrict($('#cmbProvincia').val(),$('#cmbDepartamento').val());
                    },
                    error:function(data){
                        console.log(data);
                    }
             });
        }

        function getDistrict(idprovince,iddepartment){

            $.ajax({
                url: "{{  route('ubigeo.district') }}",
                type: 'GET',
                data: { idprovince:idprovince, iddepartment: iddepartment},
                datatype: 'JSON',
                success:function(data){

                        var lista = [];

                        $.each(data, function (i, data) {

                            var option = {id:data.id,text:data.nombre}

                            lista[i] = option

                        });
                        $('#cmbDistrito').empty();
                        $('#cmbDistrito').select2({ data: lista });

                    },
                    error:function(data){
                        console.log(data);
                    }
            });
        }

        function RegistrarProveedor(objproveedor){

            $.ajax({
                url: "{{  route('proveedor.save') }}",
                type: 'POST',
                data: objproveedor,
                datatype: 'JSON',
                success:function(data){
                        if(data){alert('Proveedor Registrado')}
                        _tblProveedor.ajax.reload();
                    },
                    error:function(data){
                        console.log(data);
                    }
                });
        }

        function ModificarProveedor(objproveedor){

            $.ajax({
                url: "{{  route('proveedor.update') }}",
                type: 'POST',
                data: objproveedor,
                datatype: 'JSON',
                success:function(data){
                        if(data){alert('Proveedor Modificado')}
                        _tblProveedor.ajax.reload();
                    },
                    error:function(data){
                        console.log(data);
                    }
                });
            }

        function EliminarProveedor(id){

            $.ajax({
                url: "{{  route('proveedor.delete') }}",
                type: 'POST',
                data: {id:id},
                datatype: 'JSON',
                success:function(data){
                        console.log(data)
                         if(data){alert('Proveedor Eliminado')}
                         _tblProveedor.ajax.reload();
                    },
                    error:function(data){
                        console.log(data);
                    }
                });
        }

        function ActualizarProveedor(id){

            $.ajax({
                url: "{{  route('proveedor.delete') }}",
                type: 'POST',
                data: {id:id},
                datatype: 'JSON',
                success:function(data){
                        console.log(data)
                         if(data){alert('Proveedor Eliminado')}
                         _tblProveedor.ajax.reload();
                    },
                    error:function(data){
                        console.log(data);
                    }
                });
        }

        function LimpiarFormulario(){
             $("input[name=nombres]").val('')
             $("#cmbDepartamento").val('01').trigger('change');
             getProvince('01');
             getDistrict('01','0101')
             $("input[name=telefono]").val('')
             $("textarea[name=direccion]").val('')
        }

        function ObtenerProveedor(id){
            $.ajax({
                url: "{{  route('proveedor.only') }}",
                type: 'GET',
                data: { 'id':id},
                datatype: 'JSON',
                success:function(data){
                        console.log(data);
                     $("#accion").val('modificar')
                     $("#id").val(data[0].id)
                     $("input[name=nombres]").val(data[0].nombre)
                     $("#cmbDepartamento").val(data[0].iddepartamento).trigger('change')
                     $("#cmbProvincia").val(data[0].idprovincia).trigger('change')
                     $("#cmbDistrito").val(data[0].iddistrito).trigger('change')
                     $("textarea[name=direccion]").val(data[0].direccion)
                     $("input[name=telefono]").val(data[0].telefono)
                    },
                    error:function(data){
                        console.log(data);
                    }
             });
        }

});



</script>

 @endsection

