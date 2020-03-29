@extends('principal')

@section('scripts')
    <script src="{{asset('js/global_assets/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/tables/datatables/extensions/fixed_columns.min.js')}}"></script>

    <script src="{{asset('js/global_assets/plugins/notifications/sweet_alert.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>

    <script src="{{asset('js/global_assets/plugins/extensions/jquery_ui/interactions.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('js/global_assets/demo_pages/form_select2.js')}}"></script>

    <script src="{{asset('js/global_assets/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/forms/styling/switchery.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/forms/styling/switch.min.js')}}"></script>
    <script src="{{asset('js/global_assets/demo_pages/form_checkboxes_radios.js')}}"></script>

    <script src="{{asset('js/global_assets/demo_pages/extra_sweetalert.js')}}"></script>
    <script src="{{asset('js/global_assets/demo_pages/datatables_extension_fixed_columns.js')}}"></script>
@stop

@section('content')


<div class="content">
    <div class="card" >

        <div class="card-body" id="cardFormularioProveedor" style="display: none">
            <input type="hidden" value="" id="accion">
            <input type="hidden" value="" id="id">
            <input type="hidden" value="" id="_cmbDepartamento">
            <input type="hidden" value="" id="_cmbProvincia">
            <input type="hidden" value="" id="_cmbDistrito"> 
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">REGISTRO DE NUEVO PROVEEDOR</legend>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">NOMBRE PROVEEDOR</label>
                        <div class="col-lg-10">
                            <input type="text" name="nombres" class="form-control" placeholder="Ingresar Nombres">
                        </div>
                    </div>

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
                        <label class="col-form-label col-lg-2">TIPO DE PROVEEDOR</label>
                        <div class="col-lg-8">
                            <select id="cmbTipoServicio" data-placeholder="Servicio" class="form-control select-search" data-fouc>
                             </select>
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" name="cargar" class="btn btn-primary"  data-toggle="modal" data-target="#modal_scrollable">Agregar<i class="icon-plus-circle2 ml-2"></i></button>
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

        <!-- Scrollable modal Cargo-->
        <div id="modal_scrollable" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header pb-3">
                        <h5 class="modal-title">MANTENIMIENTO DE PROVEEDOR</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>


                    <div class="modal-body py-0">
                        <input type="hidden" id="accioncargo">
                        <input type="hidden" id="idcargo">
                        <div id="cardFormularioCargo" style="display: none;">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">SERVICIOS</label>
                                <div class="col-lg-10">
                                    <input type="text" name="nombrecargo" class="form-control" placeholder="Ingresar Servicio">
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" name="cmbGuardarServicio" class="btn btn-primary">Guardar <i class="icon-paperplane ml-2"></i></button>
                                <button type="submit" name="cmbCancelarServicio" class="btn btn-secondary">Cancelar <i class="icon-paperplane ml-2"></i></button>
                            </div>
                            <br>
                        </div>

                        <div class="card-body" id="cardAgregarCargo">
                            <div class="text-left">
                                <button type="submit" name="agregarcargo" class="btn btn-primary">Agregar Proveedor <i class="icon-file-plus ml-2"></i></button>
                            </div>
                        </div>

                        <table id="tblServicio" class="table text-center" width="100%">
                            <thead class="btn-secondary">
                                <tr>
                                    <th>TIPO PROVEEDOR</th>
                                    <th>ACCION</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer pt-3">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
                        <!-- <button type="button" class="btn bg-primary">Save changes</button> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /scrollable modal Cargo-->

    <!-- Multiple fixed columns -->
    <div class="card">
        <table id="tblProveedor" class="table" width="100%">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Distrito</th>
                    <th>Tipo Proveedor</th>
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
        // Defaults
        var swalInit = swal.mixin({
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-light'
            });
        //var resultMessage

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        ListarTipoServicioProveedor();

//TABLA PROVEEDOR
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
                { "data": "distrito" },
                { "data": "tiposervicio" },
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

//MODAL MANTENIMIENTO
        var _tblServicio =  $('#tblServicio').DataTable({
            scrollX: true,
            scrollY: '350px',
            scrollCollapse: true,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{  route('proveedor.listservicio') }}",
                "type": "GET",
                "datatype": 'JSON',

            },
            columns: [
                { "data": "nombre" },
                {
                   "data": 'id',
                   "render": function (id) {
                        var btnModificar = '<button  class="btn btn-outline-primary" name="'+id+'">Modificar</button>'
                        var btnEliminar = '<button  class="btn btn-outline-danger" name="'+id+'">Eliminar</button>'
                       return btnEliminar+' '+btnModificar;
                   }
                }

            ],
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
            var _S_INPUT_VACIO ="";
            var accion = $("#accion").val()
            var idservicio = $("input[name=cmbTipoServicio]").val()
            var id = $("#id").val()
            var nombres = $("input[name=nombres]").val()
            var departamento = $("#cmbDepartamento").val()
            var provincia = $("#cmbProvincia").val()
            var distrito = $("#cmbDistrito").val()
            var tiposervicio = $("#cmbTipoServicio").val()
            var telefono = $("input[name=telefono]").val()
            var direccion = $("textarea[name=direccion]").val()

            var objproveedor = {name:nombres, iddepartamento:departamento , idprovincia:provincia , iddistrict:distrito, idtiposervicio:tiposervicio, addres:direccion, phone:telefono, status:1, id:id}

            if($("input[name=nombres]").val() == _S_INPUT_VACIO){
                MensajeError('Recuerda', 'Ingresar el nombre del proveedor.')
                return false
            }
            // else if(distrito == _S_INPUT_VACIO){
            //     MensajeError('Recuerda', 'Seleccionar un distrito.')
            //     return false
            // }
            else if(tiposervicio == _S_INPUT_VACIO){
                MensajeError('Recuerda', 'Selecceionar un tipo de servicio.')
                return false
            }else if(telefono == _S_INPUT_VACIO){
                MensajeError('Recuerda', 'Ingresar un telefono.')
                return false
            }else if(direccion == _S_INPUT_VACIO){
                MensajeError('Recuerda', 'Ingresar una dirección.')
                return false
            }else{
                if(accion == "registrar"){
                    RegistrarProveedor(objproveedor);
                }else if(accion == "modificar"){
                    ModificarProveedor(objproveedor);
                }
            }

            $("#cardFormularioProveedor").css("display", "none")
            $("#cardAgregarProveedor").css("display", "inline")
            LimpiarFormulario();

        });

        $('#tblProveedor tbody').on( 'click','button.btn-danger', function () {
             var id = $(this)[0].name
             MensajeEliminarProveedor('Estas Seguro', 'Este registro se eliminara', id)
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

        // MODAL
        $('#modal_scrollable').on('show.bs.modal', function (e) {
            $("#accioncargo").val('registrar');
           _tblServicio.ajax.reload();
           _tblProveedor.ajax.reload();
        });

        $('#modal_scrollable').on('hidden.bs.modal', function () {
            ListarTipoServicioProveedor();
        });


        $('#tblServicio tbody').on( 'click','button.btn-outline-primary', function () {
         
             var id = $(this)[0].name
             ObtenerServicioMantenimiento(id)
             $("#cardFormularioCargo").css("display", "inline")
             $("#cardAgregarCargo").css("display", "none")
        });


        $('#tblServicio tbody').on( 'click','button.btn-outline-danger', function () {
             var id = $(this)[0].name
             MensajeEliminarConfirm('Estas Seguro?', 'Este proveedor se eliminara.',id)
             return false;
             LimpiarFormularioServicio();
        });

        $("button[name=agregarcargo]").click(function(){
             $("#accioncargo").val("registrar")
             $("#cardFormularioCargo").css("display", "inline")
             $("#cardAgregarCargo").css("display", "none")
        });

        $("button[name=cmbGuardarServicio]").click(function(){
            
            var accion = $("#accioncargo").val()
            var id = $("#idcargo").val()
            var servicio = $("input[name=nombrecargo]").val();
            var _S_VALIDAR_SERVICIO = "Ingresar el proveedor";

            servicio = servicio.toUpperCase()

            if(servicio.trim().length == 0){
                MensajeError('Recuerda', _S_VALIDAR_SERVICIO)
                return false
            }

            var servicioList = {servicio:servicio, id:id}

            BusquedaServicioMantenimiento(servicio.trim(), accion, servicioList)

            $("#cardFormularioCargo").css("display", "none")
            $("#cardAgregarCargo").css("display", "inline")
            LimpiarFormularioServicio();

        });

        $("button[name=cmbCancelarServicio]").click(function(){
            LimpiarFormularioServicio()
             $("#cardFormularioCargo").css("display", "none")
             $("#cardAgregarCargo").css("display", "inline")
        });

        //DEPARTAMENTO

        getDepartment()
        getProvince(1)
        getDistrict(1,101)
                
        function getDepartment(){   

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
                    
                },
                error:function(data){
                    console.log(data);
                }
            });
        }

        //RELACION DE FILTROS DE PROVINCIAS
        $('#cmbDepartamento').on('change', function() {
            var departamento = $("#cmbDepartamento").val()
            getProvince(departamento)
        });

        $('#cmbProvincia').on('change', function() {
            var departamento = $('#cmbDepartamento').val()
            var provincia =  $('#cmbProvincia').val()
            getDistrict(provincia,departamento)
        });

//ALERTAS VALIDACION
        function LimpiarFormularioServicio(){
            $("#accioncargo").val('')
            $("input[name=nombrecargo]").val('')
        }


        function MensajeError(titulo, mensaje){
            swalInit.fire({
                    title: titulo,
                    text: mensaje,
                    type: 'error'
            });
        }

        function MensajeCorrecto(titulo, mensaje){
            swalInit.fire({
                title: titulo,
                text: mensaje,
                type: 'success'
            });
        }

        function MensajeInformacion(titulo, mensaje){
            swalInit.fire({
                title: titulo,
                text: mensaje,
                type: 'info'
            });
        }
//FIN ALERTAS
        function MensajeEliminarConfirm(titulo, mensaje, id){

            swalInit.fire({
                title: titulo,
                text: mensaje,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'No, Cancelar!',
                confirmButtonClass: 'btn btn-danger',
                cancelButtonClass: 'btn btn-info',
                buttonsStyling: false
            }).then(function(result) {
                if (result.value){
                    EliminarServicioMantenimiento(id)
                }else{
                    console.log('message_id=>',id)
                }

            });

       }
//MANTENIMIENTO MODAL
    function BusquedaServicioMantenimiento(servicio, accion, servicioList){
            $.ajax({
                type: 'GET',
                url: "{{  route('proveedor.search') }}",
                data: {servicio:servicio},
                datatype: 'JSON',
                success:function(data){
                    var band = false
                    var _S_SERVICIO_EXISTENTE = "Este proveedor ya existe";
                    if(data.length == 1){
                        MensajeInformacion('Recuerda', _S_SERVICIO_EXISTENTE);
                        band = true
                        return false
                    }

                    if(accion == "registrar" &&  band == false){
                        RegistrarServicioMantenimiento(servicioList)
                    }else if(accion == "modificar"){
                        ModificarCargo(servicioList)
                    }

                },
                error:function(data){
                    console.log(data);
                }
            });
        }

    function ModificarCargo(servicioList){

        $.ajax({
            url: "{{  route('proveedor.updateservicio') }}",
            type: 'POST',
            data: servicioList,
            datatype: 'JSON',
            success:function(data){
                _tblServicio.ajax.reload();
                    if(data){
                        MensajeCorrecto('Excelente!', 'Proveedor actualizado correctamente.');
                        // return false;
                    }
                },
                error:function(data){
                    console.log('error===>',data)
                }
            });
    }

    function ObtenerServicioMantenimiento(id){
        $.ajax({
            url: "{{  route('proveedor.onlpro') }}",
            type: 'GET',
            data: { 'id':id},
            datatype: 'JSON',
            success:function(data){

                    $("#accioncargo").val('modificar')
                    $("#idcargo").val(data[0].id)
                    $("input[name=nombrecargo]").val(data[0].nombre)

                },
                error:function(data){
                    console.log(data);
                }
            });
    }

    function RegistrarServicioMantenimiento(servicioList){
        $.ajax({
                url: "{{  route('proveedor.saveservicio') }}",
                type: 'POST',
                data: servicioList,
                datatype: 'JSON',
                success:function(data){
                    _tblServicio.ajax.reload();
                        var _S_SERVICIO_REGISTRADO = "Proveedor registrado.";
                        if(data){
                            MensajeCorrecto('Excelente!', _S_SERVICIO_REGISTRADO);
                            // return false;
                            $('input[name=nombrecargo]').val('');
                        }
                },
                error:function(data){
                        console.log('error===>',data)
                    }
                });
            }

    function EliminarServicioMantenimiento(id){

        $.ajax({
            url: "{{  route('proveedor.deleteservicio') }}",
            type: 'POST',
            data: {id:id},
            datatype: 'JSON',
            success:function(data){
                _tblServicio.ajax.reload();
                    if(data){
                        MensajeCorrecto('Bien!', 'Proveedor eliminado correctamente');
                        // return false;
                        $("input[name=nombrecargo]").val('')

                    }
                },
                error:function(data){
                    console.log(data);
                }
        });
    }

//FIN MODAL

    //PRVINCIA
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
                        var accion = $('#accion').val()
                        var departamento = $('#_cmbDepartamento').val()
                        var provincia = $('#_cmbProvincia').val()
                        if(accion != "modificar"){
                            departamento = $('#cmbDepartamento').val()
                            provincia = $('#cmbProvincia').val() 
                        }

                         $("#cmbProvincia").val(provincia).trigger("change")
                         getDistrict(provincia,departamento)
                    },
                    error:function(data){
                        console.log(data);
                    }
             });
        }

    // DISTRITO
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
                        var accion = $('#accion').val()
                        var distrito = $('#_cmbDistrito').val()
                        if(accion != "modificar"){
                             distrito = $('#cmbDistrito').val()
                        }
                        $("#cmbDistrito").val(distrito).trigger('change')

                    },
                    error:function(data){
                        console.log(data);
                    }
            });
    }

    // TIPO SERVICIO
    function ListarTipoServicioProveedor(){
        $.ajax({
            url: "{{  route('proveedor.tiposervicio') }}",
            type: 'GET',
            datatype: 'JSON',
            success:function(data){
                    $('#cmbTipoServicio').empty();
                    var lista = [];
                    var seleccione = {id:0, text:'---SELECCIONE---'}
                    lista[0] = seleccione
                    $.each(data, function (i, data) {
                        var option = {id:data.id,text:data.nombre}
                        lista[i+1] = option
                    });
                    $('#cmbTipoServicio').select2({ data: lista });
                    

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
                _tblProveedor.ajax.reload();
                    if(data){
                        MensajeCorrecto('Excelente!', 'Se registro correctamente.');
                        // return false;
                    }
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
                _tblProveedor.ajax.reload();
                    if(data){
                        MensajeCorrecto('Bien!', 'Se modificó correctamente.') }
                        // return false
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
                _tblProveedor.ajax.reload();
                    // console.log(data)
                        if(data){
                            MensajeCorrecto('Bien!', 'Se eliminó correctamente.')
                            // return false
                        }
                },
                error:function(data){
                    console.log(data);
                }
            });
    }

    function MensajeEliminarProveedor(titulo, mensaje, id){
            
            swalInit.fire({
                title: titulo,
                text: mensaje,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'No, Cancelar!',
                confirmButtonClass: 'btn btn-danger',
                cancelButtonClass: 'btn btn-info',
                buttonsStyling: false
            }).then(function(result) {
                if (result.value){
                    //console.log('true',id)
                    EliminarProveedor(id)
                }else{
                    //console.log('undefined',id)
                }
                
            });
            
       }

    function LimpiarFormulario(){
            $("input[name=nombres]").val('')
            $("input[name=telefono]").val('')
            $("textarea[name=direccion]").val('')
            $("#accioncargo").val('')
            $("input[name=nombrecargo]").val('')
            $("#cmbDepartamento").val(1).trigger('change')
            getProvince(1)
            getDistrict(1,101)
            $("#cmbTipoServicio").val(0).trigger('change')
    }

    function ObtenerProveedor(id){
       
        $.ajax({
            url: "{{  route('proveedor.only') }}",
            type: 'GET',
            data: { 'id':id},
            datatype: 'JSON',
            success:function(data){
                    console.log(data);

                    $("#_cmbDepartamento").val(data[0].iddepartamento)
                    $("#_cmbProvincia").val(data[0].idprovincia)
                    $("#_cmbDistrito").val(data[0].iddistrito)  

                    $("#accion").val('modificar')
                    $("#id").val(data[0].id)
                    $("input[name=nombres]").val(data[0].nombre)
                    $("#cmbDepartamento").val(data[0].iddepartamento).trigger('change')
                    $("#cmbProvincia").val(data[0].idprovincia).trigger('change')
                    $("#cmbDistrito").val(data[0].iddistrito).trigger('change')
                    $("#cmbTipoServicio").val(data[0].idtiposervicio).trigger('change')
                    $("textarea[name=direccion]").val(data[0].direccion)
                    $("input[name=telefono]").val(data[0].telefono)
                },
                error:function(data){
                    console.log(data);
                }
            });
        }
//FIN DOCUMENT READY
});
</script>

 @endsection

