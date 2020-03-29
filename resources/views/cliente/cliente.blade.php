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

    <script src="{{asset('js/global_assets/demo_pages/datatables_extension_fixed_columns.js')}}"></script>

    <script src="{{asset('js/global_assets/demo_pages/extra_sweetalert.js')}}"></script>
   
@stop


@section('content')
<div class="content">
    <div class="card" >
   
        <div class="card-body" id="cardFormularioCliente" style="display: none">
                <input type="hidden" value="" id="accion"> 
                <input type="hidden" value="" id="id">
                <input type="hidden" value="" id="_cmbDepartamento">
                <input type="hidden" value="" id="_cmbProvincia">
                <input type="hidden" value="" id="_cmbDistrito"> 
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">REGISTRO CLIENTE</legend>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">NOMBRES</label>
                        <div class="col-lg-10">
                            <input type="text" name="nombres" class="form-control" placeholder="Ingresar Nombres">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">FECHA INGRESO</label>
                        <div class="col-lg-10">
                            <input type="date" name="fechaingreso" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">PUBLICIDAD</label>
                        <div class="col-lg-10">
                            <select id="cmbPublicidad"  data-placeholder="Publicidad" class="form-control select-search" data-fouc>
                             </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">PROGRAMACION VISITA</label>
                        <div class="col-lg-10">
                            <input type="text" name="programacionvisita" class="form-control" placeholder="Ingresar Programacion Visita">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">TIPO CLIENTE</label>
                        <div class="col-lg-10">
                            <select id="cmbTipoCliente"  data-placeholder="Tipo Cliente" class="form-control select-search" data-fouc>
                             </select>
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
        <div class="card-body" id="cardAgregarCliente">
            <div class="text-left">
                <button type="submit" name="agregar" class="btn btn-primary">Agregar Cliente <i class="icon-file-plus ml-2"></i></button>
            </div>
        </div>
    </div>

    <!-- Basic modal -->
        <div id="modal_default" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">DETALLE ORDENES</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">CLIENTE</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">TOTAL ORDENES</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" value="6" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">BUSCADOR POR FECHA</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <table  class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>FECHA</th>
                                    <th>N° ORDEN</th>
                                    <th>DETALLE DE ORDEN</th> 
                                </tr>
                            </thead>
                            <tbody>
                               <tr>
                                    <td>20/03/2020</td>
                                    <td>123</td>
                                    <td>LIMPIEZA COCINA</td> 
                                </tr>
                                <tr>
                                    <td>20/03/2020</td>
                                    <td>123</td>
                                    <td>LIMPIEZA COCINA</td> 
                                </tr>
                                <tr>
                                    <td>20/03/2020</td>
                                    <td>123</td>
                                    <td>LIMPIEZA COCINA</td> 
                                </tr>
                                <tr>
                                    <td>20/03/2020</td>
                                    <td>123</td>
                                    <td>LIMPIEZA COCINA</td> 
                                </tr>
                                <tr>
                                    <td>20/03/2020</td>
                                    <td>123</td>
                                    <td>LIMPIEZA COCINA</td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
                        <!-- <button type="button" class="btn bg-primary">Save changes</button> -->
                    </div>
                </div>
            </div>
        </div>
 <!-- /basic modal -->


<!-- Multiple fixed columns -->
    <div class="card"> 
        <div class="card-body">
            <div class="form-group row">
                <label class="col-form-label col-lg-2">FILTRO AÑO</label>
                <div class="col-lg-3">
                    <input type="text" id="filtroyear" class="form-control" placeholder="yyyy">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-2">FILTRO MES</label>
                <div class="col-lg-3">
                    <select id="cmbMes"  data-placeholder="Mes" class="form-control select-search" data-fouc>
                         <option value="0">SELECCIONE</option>
                         <option value="enero">ENERO</option>
                         <option value="febrero">FEBRERO</option>
                         <option value="marzo">MARZO</option>
                         <option value="abril">ABRIL</option>
                         <option value="mayo">MAYO</option>
                         <option value="junio">JUNIO</option>
                         <option value="julio">JULIO</option>
                         <option value="agosto">AGOSTO</option>
                         <option value="septiembre">SEPTIEMBRE</option>
                         <option value="octubre">OCTUBRE</option>
                         <option value="noviembre">NOVIEMBRE</option>
                         <option value="diciembre">DICIEMBRE</option>
                     </select>
                </div>
            </div>
        </div>
        <table id="tblCliente" class="table" width="100%">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>N° Orden</th>
                    <th>Fecha Ingreso</th>
                    <th>Publicidad</th>
                    <th>Programacion Visita</th>
                    <th>TipoCliente</th>
                    <th>Departamento</th>
                    <th>Provincia</th>
                    <th>Distrito</th>
                    <th>Telefono</th>
                    <th>Direccion</th>
                    <th>Año</th>
                    <th>Mes</th>
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      var _tblCliente =  $('#tblCliente').DataTable({
            scrollX: true,
            scrollY: '350px',
            scrollCollapse: true,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{  route('client.list') }}",
                "type": "GET",
                "datatype": 'JSON',
                // success:function(data){                   
                    
                //     console.log(data)

                // },
                // error:function(data){
                //     console.log(data)
                // }                
            },
            columns: [
                { "data": "nombre" },
                {
                   "data": 'id',
                   "render": function (id) {
                        var link = '<button type="button" class="btn btn-outline-primary border-transparent" data-toggle="modal" data-target="#modal_default">6</button>';
                        
                       return link;
                   }
                },
                { "data": "fechaingreso" },              
                { "data": "publicidad" },
                { "data": "programacionvisita" },
                { "data": "tipocliente" },
                { "data": "departamento" },
                { "data": "provincia" },
                { "data": "distrito" },                
                { "data": "telefono" }, 
                { "data": "direccion" },
                { "data": "yyyy" },
                { "data": "mm" },
                {
                   "data": 'id',
                   "render": function (id) {
                        var btnEliminar = "<button type='button' name="+id+" class='btn btn-danger rounded-round'><i class='icon-bin'></i></button>";
                        var btnActulizar = "<button type='button' name="+id+" class='btn btn-primary rounded-round'><i class='icon-compose'></i></button>";
                       return btnEliminar+" "+btnActulizar;
                   }
                }
                // render: function (data, type, full, meta) {
                //     return 'a-----';
                // }               
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
            }
           
        });
        

        $('#filtroyear').keyup( function() {
            // console.log(this.value)
            var year = this.value
            var mes = $("#cmbMes").val()
            if(mes == 0){ mes = "" }

            if(year.trim().length > 0){

                if(mes == ""){
                    _tblCliente.search(year).draw();
                }else{
                    _tblCliente.search(year).draw();
                    _tblCliente.search(mes).draw();
                }
                
            }
            if(year.trim().length == 0){
                if(mes == ""){
                    _tblCliente.search(year).draw();
                }else{
                    _tblCliente.search(year).draw();
                    _tblCliente.search(mes).draw();
                }                
            }

            
        } );

        $("#cmbMes").change(function () {

            var year = $('#filtroyear').val()
            var mes = this.value
            if(mes == 0){ mes = "" }

            if(year.trim().length > 0 ){
                if(mes==""){
                    _tblCliente.search(mes).draw();
                    _tblCliente.search(year.trim()).draw();
                }else{
                    _tblCliente.search(year.trim()).draw();
                    _tblCliente.search(mes).draw();
                }
                
            }
            
            if(year.trim().length == 0){
                _tblCliente.search(mes).draw();            
            }
            
        });

        
        $("button[name=guardar]").click(function(){
            var accion = $("#accion").val()
            var id = $("#id").val()
            var nombres = $("input[name=nombres]").val()
            var fechaingreso = $("input[name=fechaingreso]").val()
            var idpublicidad = $("#cmbPublicidad").val()
            var programacionvisita = $("input[name=programacionvisita]").val()
            var idtipocliente = $("#cmbTipoCliente").val()
            var departamento = $("#cmbDepartamento").val()
            var provincia = $("#cmbProvincia").val()
            var distrito = $("#cmbDistrito").val()
            var telefono = $("input[name=telefono]").val()
            var direccion = $("textarea[name=direccion]").val()

            nombres = nombres.toUpperCase()
            //fechaingreso = fechaingreso+' 12:00:00'

            var cliente = {name:nombres, iddepartment:departamento, idprovince:provincia, iddistrict:distrito, addres:direccion, phone:telefono, fechaingreso:fechaingreso, idpublicidad:idpublicidad, programacionvisita:programacionvisita, idtipocliente:idtipocliente, id: id}


            if(nombres.trim().length == 0){
                MensajeError('Recuerda', 'Ingresar Nombres!')
                return false
            } 
            if(fechaingreso.trim().length == 0){
                MensajeError('Recuerda', 'Seleccionar Fecha!')
                return false
            }
            if(idpublicidad == 0){
                MensajeError('Recuerda', 'Seleccionar Publicidad!')
                return false
            } 
            if(programacionvisita.trim().length == 0){
                MensajeError('Recuerda', 'Ingresar Programacion Visita!')
                return false
            }
            if(idtipocliente == 0){
                MensajeError('Recuerda', 'Seleccionar Tipo Cliente!')
                return false
            }
            if(telefono.trim().length == 0){
                MensajeError('Recuerda', 'Ingresar Telefono!')
                return false
            }
            if(direccion.trim().length == 0){
                MensajeError('Recuerda', 'Ingresar Direccion!')
                return false
            }
            
           
            if(accion == "registrar"){
                RegistrarCliente(cliente)
            }else if(accion == "modificar"){
                ModificarCliente(cliente)
            }           
            $("#cardFormularioCliente").css("display", "none")
            $("#cardAgregarCliente").css("display", "inline")
            LimpiarFormulario();

        });

        $('#tblCliente tbody').on( 'click','button.btn-danger', function () {
             var id = $(this)[0].name 
             MensajeEliminarCliente('Estas Seguro', 'Este registro se eliminara',id)                     
             //EliminarCliente(id)   
        });

        $('#tblCliente tbody').on( 'click','button.btn-primary', function () {
             var id = $(this)[0].name          
             ObtenerCliente(id)
             $("#cardFormularioCliente").css("display", "inline")
             $("#cardAgregarCliente").css("display", "none")
        });

        $("button[name=agregar]").click(function(){
             $("#accion").val("registrar")
             $("#cardFormularioCliente").css("display", "inline")
             $("#cardAgregarCliente").css("display", "none")
        });

        $("button[name=cancelar]").click(function(){
             LimpiarFormulario()
             $("#cardFormularioCliente").css("display", "none")
             $("#cardAgregarCliente").css("display", "inline")             
        });

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

        //LISTA PUBLICIDAD
        $.ajax({    
            type: 'GET',
            url: "{{  route('publicidad.list') }}",
            datatype: 'JSON',
            success:function(data){

                var lista = [];

                $('#cmbPublicidad').empty();
                var seleccione = {id:0, text:'----SELECCIONE----'}

                lista[0] = seleccione

                $.each(data, function (i, data) {
                    var option = {id:data.id,text:data.nombre}
                    lista[i+1] = option
                });
                
                $('#cmbPublicidad').select2({ data: lista });
                
            },
            error:function(data){
                console.log(data);
            }
        });

        //LISTA TIPO CLIENTE
        $.ajax({    
            type: 'GET',
            url: "{{  route('tipocliente.list') }}",
            datatype: 'JSON',
            success:function(data){

                var lista = [];
                $('#cmbTipoCliente').empty();
                var seleccione = {id:0, text:'----SELECCIONE----'}

                lista[0] = seleccione
                $.each(data, function (i, data) {
                    var option = {id:data.id,text:data.nombre}
                    lista[i+1] = option
                });
                
                $('#cmbTipoCliente').select2({ data: lista });
                
            },
            error:function(data){
                console.log(data);
            }
        });

        

        $('#cmbDepartamento').on('change', function() { 
           var departamento = $("#cmbDepartamento").val() 
            getProvince(departamento)
                          
        });

        $('#cmbProvincia').on('change', function() { 
          var departamento = $('#cmbDepartamento').val()
          var provincia =  $('#cmbProvincia').val()
           getDistrict(provincia,departamento)
                             
        });

        

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

        function MensajeEliminarCliente(titulo, mensaje, id){
            
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
                    EliminarCliente(id)
                }else{
                    //console.log('undefined',id)
                }
                
            });
            
       }


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

        function RegistrarCliente(cliente){

            $.ajax({              
                url: "{{  route('client.save') }}",
                type: 'POST',
                data: cliente,
                datatype: 'JSON',
                success:function(data){ 
                        _tblCliente.ajax.reload();                  
                        if(data){ MensajeCorrecto('Bien!', 'Cliente Guardado!')}                       
                        
                    },
                    error:function(data){
                        console.log(data);
                    }
                });
        }

        function ModificarCliente(cliente){

            $.ajax({              
                url: "{{  route('client.update') }}",
                type: 'POST',
                data: cliente,
                datatype: 'JSON',
                success:function(data){  
                        _tblCliente.ajax.reload();                 
                        if(data){MensajeCorrecto('Bien!', 'Cliente actualizado correctamente!')}                       
                        
                    },
                    error:function(data){
                        console.log(data);
                    }
                });
        }

        function EliminarCliente(id){

            $.ajax({              
                url: "{{  route('client.delete') }}",
                type: 'POST',
                data: {id:id},
                datatype: 'JSON',
                success:function(data){  
                        _tblCliente.ajax.reload();              
                        if(data){MensajeCorrecto('Bien!', 'Cliente eliminado correctamente!')}                       
                         
                    },
                    error:function(data){
                        console.log(data);
                    }
                });
        }

        // function ActualizarCliente(id){

        //     $.ajax({              
        //         url: "{{  route('client.delete') }}",
        //         type: 'POST',
        //         data: {id:id},
        //         datatype: 'JSON',
        //         success:function(data){  
        //                 _tblCliente.ajax.reload();               
        //                  if(data){MensajeCorrecto('Bien!', 'Cliente actualizado correctamente!')}                       
                         
        //             },
        //             error:function(data){
        //                 console.log(data);
        //             }
        //         });
        // }

        function LimpiarFormulario(){
            $("#accion").val('')
             $("input[name=nombres]").val('')
             $("#cmbDepartamento").val(1).trigger('change')
             getProvince(1)
             getDistrict(1,101)
             $("input[name=telefono]").val('')
             $("textarea[name=direccion]").val('')
             $("input[name=fechaingreso]").val('')
             $("#cmbPublicidad").val(0).trigger('change')
             $("input[name=programacionvisita]").val('')
             $("#cmbTipoCliente").val(0).trigger('change')
        }

        function ObtenerCliente(id){
            $.ajax({              
                url: "{{  route('client.only') }}",
                type: 'GET',
                data: { 'id':id},
                datatype: 'JSON',
                success:function(data){                       
                         // console.log(data);  
                         
                     $("#_cmbDepartamento").val(data[0].iddepartamento)
                     $("#_cmbProvincia").val(data[0].idprovincia)
                     $("#_cmbDistrito").val(data[0].iddistrito)    

                     $("#accion").val('modificar')
                     $("#id").val(data[0].id)
                     $("input[name=nombres]").val(data[0].nombre)
                     $("input[name=fechaingreso]").val( formatoFecha(data[0].fechaingreso))
                     $("#cmbPublicidad").val(data[0].idpublicidad).trigger('change')
                     $("input[name=programacionvisita]").val(data[0].programacionvisita)
                     $("#cmbTipoCliente").val(data[0].idtipocliente).trigger('change')
                     $("#cmbDepartamento").val(data[0].iddepartamento).trigger('change')
                     $("#cmbProvincia").val(data[0].idprovincia).trigger('change')
                     $("#cmbDistrito").val(data[0].iddistrito).trigger('change')
                     $("input[name=telefono]").val(data[0].telefono)
                     $("textarea[name=direccion]").val(data[0].direccion)
                     
                        
                    },
                    error:function(data){
                        console.log(data);
                    }
             });
        }
        function formatoFecha(fecha){
            var a = fecha.split('/');
            // console.log('a',a)
            return a[2]+"-"+a[1]+"-"+a[0]
        }

});

    

</script>

 @endsection
