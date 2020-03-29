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
    <div class="card">
        <div class="card-body" id="cardFormularioWorker" style="display: none">
                <input type="hidden" value="" id="accion"> 
                <input type="hidden" value="" id="id">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">REGISTRO DE USUARIOS</legend>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">USUARIO/LOGIN</label>
                        <div class="col-lg-10">
                            <input type="text" name="usuario" class="form-control" placeholder="Ingresar Usuario">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">PASSWORD</label>
                        <div class="col-lg-10">
                            <input type="text" name="password" class="form-control" placeholder="Ingresar Password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">NOMBRES Y APELLIDOS</label>
                        <div class="col-lg-10">
                            <input type="text" name="nombres" class="form-control" placeholder="Ingresar Nombres">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">CARGO</label>
                        <div class="col-lg-8">
                            <select id="cmbCargo" data-placeholder="Cargo" class="form-control select-search" data-fouc>
                             </select>
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" name="cargar" class="btn btn-primary"  data-toggle="modal" data-target="#modal_scrollable">Agregar<i class="icon-plus-circle2 ml-2"></i></button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">DNI</label>
                        <div class="col-lg-10">
                            <input type="text" name="dni" class="form-control" maxlength="25" placeholder="Ingresar Dni">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">CORREO</label>
                        <div class="col-lg-10">
                            <input type="text" name="correo" class="form-control" placeholder="Ingresar Correo">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">TELEFONO</label>
                        <div class="col-lg-10">
                            <input type="text" name="telefono" class="form-control" maxlength="25" placeholder="Ingresar Telefono">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">DIRECCION</label>
                        <div class="col-lg-10">
                            <textarea rows="3" cols="3" name="direccion" class="form-control" placeholder="Ingresar Direccion"></textarea>
                        </div>
                    </div>

                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" name="vigencia" class="form-check-input-styled" checked  data-fouc>
                            Vigencia
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" name="maestro" class="form-check-input-styled"  data-fouc>
                            Contraseña Maestra
                        </label>
                    </div>
                    <div class="form-group row invisible" id="divmaestro">
                        <label class="col-form-label col-lg-2">CONTRASEÑA MAESTRA</label>
                        <div class="col-lg-10">
                            <input type="text" name="passwordmaestro" class="form-control" placeholder="Ingresar Contraseña Maestra">
                        </div>
                    </div>
                </fieldset>

                <div class="text-right">
                    <button type="submit" name="guardar" class="btn btn-primary">Guardar <i class="icon-paperplane ml-2"></i></button>
                    <button type="submit" name="cancelar" class="btn btn-secondary">Cancelar <i class="icon-paperplane ml-2"></i></button>
                </div>

        </div>
        <div class="card-body" id="cardAgregarWorker">
            <div class="text-left">
                <button type="submit" name="agregar" class="btn btn-primary">Agregar Usuario <i class="icon-file-plus ml-2"></i></button>
            </div>
        </div>
    </div>

    <!-- Scrollable modal Cargo-->
    <div id="modal_scrollable" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header pb-3">
                    <h5 class="modal-title">GESTION CARGOS</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                

                <div class="modal-body py-0">
                    <input type="hidden" id="accioncargo">
                    <input type="hidden" id="idcargo">
                    <div id="cardFormularioCargo" style="display: none;">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">CARGO</label>
                            <div class="col-lg-10">
                                <input type="text" name="nombrecargo" class="form-control" placeholder="Ingresar Cargo">
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" name="guardarcargo" class="btn btn-primary">Guardar <i class="icon-paperplane ml-2"></i></button>
                            <button type="submit" name="cancelarcargo" class="btn btn-secondary">Cancelar <i class="icon-paperplane ml-2"></i></button>
                        </div>
                        <br>
                    </div>
                    <div class="card-body" id="cardAgregarCargo">
                        <div class="text-left">
                            <button type="submit" name="agregarcargo" class="btn btn-primary">Agregar Cargo <i class="icon-file-plus ml-2"></i></button>
                        </div>
                    </div>
                    <table id="tblCargo" class="table text-center" width="100%">
                        <thead class="btn-secondary">
                            <tr>
                                <th>CARGO</th>
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

    <!-- Scrollable modal  Permiso-->
    <div id="modal_scrollable_permiso" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header pb-3">
                    <h5 class="modal-title">GESTION PERMISOS</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <div class="modal-body py-0">
                    <input type="hidden" id="idusuario">
                    <div class="text-left">
                        <button type="submit" name="guardarpermiso" class="btn btn-primary">Guardar<i class="icon-file-plus2 ml-2"></i></button>
                    </div>
                    <br>
                    <table id="tblPermiso" class="table text-center" width="100%">
                        <thead class="btn-success">
                            <tr>
                                <th>MENU</th>
                                <th>SUBMENU</th>
                                <th><input type="checkbox" name="chkall"></th>
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
    <!-- /scrollable modal Permiso-->


    <!-- Multiple fixed columns -->
    <div class="card">
        <table id="tblWorker" class="table text-center" width="100%">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Cargo</th>
                    <th>Nombres y Apellidos</th>
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

      var _tblWorker =  $('#tblWorker').DataTable({
            scrollX: true,
            scrollY: '350px',
            scrollCollapse: true,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{  route('worker.list') }}",
                "type": "GET",
                "datatype": 'JSON',
                // success:function(data){
                //     console.log(data)
                // },
                // error:function(data){
                //     console.log(data);
                // }
            },
            columns: [
                { "data": "usuario" },
                { "data": "cargo" },
                { "data": "nombre" },
                {
                   "data": 'id',
                   "render": function (id) {
                        var btnEliminar = "<button type='button' name="+id+" class='btn btn-danger rounded-round'><i class='icon-bin'></i></button>";
                        var btnActulizar = "<button type='button' name="+id+" class='btn btn-primary rounded-round'><i class='icon-compose'></i></button>";
                        var btnPermiso = "<button type='button' name="+id+" class='btn btn-success rounded-round' data-toggle='modal' data-target='#modal_scrollable_permiso'>Permiso <i class='icon-database-diff'></i></button>";
                       return btnEliminar + " " + btnActulizar + " "+ btnPermiso;
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
            },
        });

       var _tblCargo =  $('#tblCargo').DataTable({
            scrollX: true,
            scrollY: '350px',
            scrollCollapse: true,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{  route('cargo.list') }}",
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

       $('#modal_scrollable').on('show.bs.modal', function (e) {
            $("#accioncargo").val('registrar');
           _tblCargo.ajax.reload();
           _tblWorker.ajax.reload();
        });

       $('#modal_scrollable_permiso').on('show.bs.modal', function (e) {
            var idusuario = e.relatedTarget.name
            $("#idusuario").val(idusuario)
            ListaMenu();
            ListaMenuPermiso(idusuario);
        });

       $('#modal_scrollable').on('hidden.bs.modal', function () {
            ListaCargo();
        });

        $("button[name=guardar]").click(function(){
            var accion = $("#accion").val()
            var id = $("#id").val()
            var usuario = $("input[name=usuario]").val()
            var password = $("input[name=password]").val()
            var nombres = $("input[name=nombres]").val()
            var dni = $("input[name=dni]").val()
            var correo = $("input[name=correo]").val()
            var telefono = $("input[name=telefono]").val()
            var direccion = $("textarea[name=direccion]").val()
            var vigencia = $("input[name=vigencia]").prop("checked")
            var maestro = $("input[name=maestro]").prop("checked")
            var idcargo =  $("#cmbCargo").val()
            var passwordmaestro = $("input[name=passwordmaestro]").val()
        
            nombres = nombres.toUpperCase()

            var objusuario = {usuario:usuario, password:password, nombres:nombres, dni:dni, correo:correo, telefono:telefono, direccion: direccion, vigencia:vigencia, idcargo: idcargo, passwordmaestro: passwordmaestro, id: id}


            if(usuario.trim().length == 0){
                MensajeError('Recuerda', 'Ingresar Usuario!')
                return false
            } 
            if(password.trim().length == 0){
                MensajeError('Recuerda', 'Ingresar Password!')
                return false
            }
            if(nombres.trim().length == 0){
                MensajeError('Recuerda', 'Ingresar Nombres!')
                return false
            }
            if(idcargo == 0){
                MensajeError('Recuerda', 'Seleccionar Cargo!')
                return false
            }
            if(dni.trim().length == 0){
                MensajeError('Recuerda', 'Ingresar Dni!')
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
        
            searchUsuario(usuario.trim(), accion, objusuario)

            

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

        function MensajeEliminarWorker(titulo, mensaje, id){
            
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
                    EliminarWorker(id)
                }else{
                    //console.log('undefined',id)
                }
                
            });
            
       }

       function MensajeEliminarCargo(titulo, mensaje, id){
            
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
                    EliminarCargo(id)
                }else{
                    //console.log('undefined',id)
                }
                
            });
            
       }

        $("button[name=guardarcargo]").click(function(){
            
            var accion = $("#accioncargo").val()
            var id = $("#idcargo").val()
            var cargo = $("input[name=nombrecargo]").val()
                     
            cargo = cargo.toUpperCase()

            if(cargo.trim().length == 0){
                MensajeError('Recuerda', 'Ingresar Cargo!')
                return false
            }

            var objcargo = {cargo:cargo, id: id}

            searchCargo(cargo.trim(), accion, objcargo)
            
            $("#cardFormularioCargo").css("display", "none")
            $("#cardAgregarCargo").css("display", "inline")
            LimpiarFormularioCargo();

        });

        $("button[name=guardarpermiso]").click(function(){
            var idusuario = $("#idusuario").val()
            $('#tblPermiso tbody').find(".chkonly").each(function() {
                
                if(this.checked){
                    RegistrarPermiso(idusuario, this.name, 1)
                }else{
                    RegistrarPermiso(idusuario, this.name, 0)
                } 

            })

            $('#modal_scrollable_permiso').modal('toggle');
            _tblWorker.ajax.reload();

            MensajeCorrecto('Bien!', 'Permiso Guardado!')

        });

        $('input[name=maestro]').change(function() {
            if(this.checked) {
               $("#divmaestro").removeClass("invisible").addClass("visible");
            }else{
               $("#divmaestro").removeClass("visible").addClass("invisible");
            }              
        });

        $('input[name=chkall]').change(function() {
            if(this.checked) {
               $(".chkonly").prop("checked",true);
            }else{
               $(".chkonly").prop("checked",false);
            }              
        });

        $('#tblWorker tbody').on( 'click','button.btn-danger', function () {
             var id = $(this)[0].name
             MensajeEliminarWorker('Estas Seguro', 'Este registro se eliminara',id)            
        });

        $('#tblWorker tbody').on( 'click','button.btn-primary', function () {
             var id = $(this)[0].name          
             ObtenerWorker(id)
             $("#cardFormularioWorker").css("display", "inline")
             $("#cardAgregarWorker").css("display", "none")
             $("input[name=usuario]").attr("disabled", true)
        });


        $('#tblCargo tbody').on( 'click','button.btn-outline-primary', function () {
             var id = $(this)[0].name          
             ObtenerCargo(id)
             $("#cardFormularioCargo").css("display", "inline")
             $("#cardAgregarCargo").css("display", "none")
        });


        $('#tblCargo tbody').on( 'click','button.btn-outline-danger', function () {
             var id = $(this)[0].name 
             MensajeEliminarCargo('Estas Seguro', 'Este cargo se eliminara',id)         
             LimpiarFormularioCargo();
        });

        $("button[name=agregar]").click(function(){
             $("input[name=usuario]").attr("disabled", false)
             $("#accion").val("registrar")
             $("#cardFormularioWorker").css("display", "inline")
             $("#cardAgregarWorker").css("display", "none")
        });

        $("button[name=agregarcargo]").click(function(){
             $("#accioncargo").val("registrar")
             $("#cardFormularioCargo").css("display", "inline")
             $("#cardAgregarCargo").css("display", "none")
        });

        $("button[name=cancelar]").click(function(){
            LimpiarFormulario()
             $("#cardFormularioWorker").css("display", "none")
             $("#cardAgregarWorker").css("display", "inline")
             $("input[name=agregar]").css("display", "inline")
        });

        $("button[name=cancelarcargo]").click(function(){
            LimpiarFormularioCargo()
             $("#cardFormularioCargo").css("display", "none")
             $("#cardAgregarCargo").css("display", "inline")
        });

        ListaCargo();


        function ListaCargo(){
            $.ajax({    
                type: 'GET',
                url: "{{ URL::to('cargo/cargo')}}",
                datatype: 'JSON',
                success:function(data){
                    
                    $('#cmbCargo').empty();
                    var lista = [];
                    var seleccione = {id:0, text:'----SELECCIONE----'}

                    lista[0] = seleccione
                    $.each(data, function (i, data) {
                        var option = {id:data.id,text:data.nombre}
                        lista[i+1] = option                                          
                    });
                    
                    $('#cmbCargo').select2({ data: lista });

                },
                error:function(data){
                    console.log(data);
                }
            });
        }

        function ListaMenu(){
            $.ajax({    
                type: 'GET',
                url: "{{ URL::to('permiso/menu')}}",
                datatype: 'JSON',
                success:function(data){
                 $('#tblPermiso > tbody').empty();

                 for (var i = 0; i < data.length; i++) { 

                     var menu = data[i].menu
                     var submenu =  data[i].submenu  
                     var check = '<input type="checkbox" name="'+data[i].idsubmenu+'" class="chkonly">'

                     $("#tblPermiso > tbody:last-child").append("<tr><td>"+menu+"</td><td>"+submenu+"</td>"+
                        "<td>"+check+"</td></tr>");
                     
                    }

                },
                error:function(data){
                    console.log(data);
                }
            });            
        }

        function ListaMenuPermiso(idusuario){
            
            $.ajax({    
                type: 'GET',
                url: "{{ URL::to('permiso/permiso')}}",
                data: {idusuario:idusuario},
                datatype: 'JSON',
                success:function(data){
                    
                 $("#tblPermiso > tbody").find(".chkonly").prop("checked",false);

                 for (var i = 0; i < data.length; i++) { 
                     
                     var idsubmenu =  data[i].idsubmenu
                     $("#tblPermiso > tbody").find("input[name="+idsubmenu+"]").prop("checked",true);
                     
                    }

                },
                error:function(data){
                    console.log(data);
                }
            });            
        }

        function RegistrarPermiso(idusuario, idsubmenu, estado){
            
            $.ajax({    
                type: 'POST',
                url: "{{  route('permiso.save') }}",
                data: {idusuario:idusuario, idsubmenu:idsubmenu, estado: estado},
                datatype: 'JSON',
                success:function(data){
                    //console.log('zzzz=>',data)                 
                },
                error:function(data){
                    console.log(data);
                }
            });            
        }




        function searchUsuario(usuario, accion, objusuario){
            $.ajax({    
                type: 'GET',
                url: "{{  route('worker.search') }}",
                data: {usuario:usuario},
                datatype: 'JSON',
                success:function(data){
                    var band = false
                    if(data.length == 1 && accion == "registrar"){
                        MensajeInformacion('Recuerda', 'Este usuario ya existe')
                        band = true
                        return false;
                    }

                    if(accion == "registrar" &&  band == false){
                        RegistrarWorker(objusuario)
                        $("#cardFormularioWorker").css("display", "none")
                        $("#cardAgregarWorker").css("display", "inline")
                        LimpiarFormulario();
                    }else if(accion == "modificar"){
                        ModificarWorker(objusuario)
                        $("#cardFormularioWorker").css("display", "none")
                        $("#cardAgregarWorker").css("display", "inline")
                        LimpiarFormulario();
                    } 
                    
                },
                error:function(data){
                    console.log(data);
                }
            });
        }

        function searchCargo(cargo, accion, objcargo){
            $.ajax({    
                type: 'GET',
                url: "{{  route('cargo.search') }}",
                data: {cargo:cargo},
                datatype: 'JSON',
                success:function(data){
                    var band = false
                    if(data.length == 1){
                        MensajeInformacion('Recuerda', 'Este cargo ya existe')
                        band = true
                        return false
                    }
                    
                    if(accion == "registrar" &&  band == false){
                        RegistrarCargo(objcargo)
                    }else if(accion == "modificar"){
                        ModificarCargo(objcargo)
                    } 
                    
                },
                error:function(data){
                    console.log(data);
                }
            });
        }

        function RegistrarWorker(objusuario){
                
            $.ajax({
                url: "{{  route('worker.save') }}",
                type: 'POST',
                data: objusuario,
                datatype: 'JSON',
                success:function(data){
                        _tblWorker.ajax.reload();
                        if(data){ MensajeCorrecto('Bien!', 'Usuario Guardado!') }
                        
                    },
                    error:function(data){
                        console.log('error===>',data)
                    }
                });
        }

        function RegistrarCargo(objcargo){
                
            $.ajax({
                url: "{{  route('cargo.save') }}",
                type: 'POST',
                data: objcargo,
                datatype: 'JSON',
                success:function(data){
                        _tblCargo.ajax.reload();
                        if(data){MensajeCorrecto('Bien!', 'Cargo Guardado!')}
                        
                    },
                    error:function(data){
                        console.log('error===>',data)
                    }
                });
        }

        function EliminarWorker(id){

            $.ajax({
                url: "{{  route('worker.delete') }}",
                type: 'POST',
                data: {id:id},
                datatype: 'JSON',
                success:function(data){
                         _tblWorker.ajax.reload();
                         if(data){MensajeCorrecto('Bien!', 'Usuario eliminado correctamente')}
                    },
                    error:function(data){
                        console.log(data);
                    }
            });
        }

        function EliminarCargo(id){

            $.ajax({
                url: "{{  route('cargo.delete') }}",
                type: 'POST',
                data: {id:id},
                datatype: 'JSON',
                success:function(data){
                         _tblCargo.ajax.reload();
                         if(data){MensajeCorrecto('Bien!', 'Cargo eliminado correctamente')}
                    },
                    error:function(data){
                        console.log(data);
                    }
                });
        }

        function ModificarWorker(worker){

            $.ajax({              
                url: "{{  route('worker.update') }}",
                type: 'POST',
                data: worker,
                datatype: 'JSON',
                success:function(data){ 
                        _tblWorker.ajax.reload();       
                        if(data){MensajeCorrecto('Bien!', 'Usuario actualizado correctamente')}                       
                        
                    },
                    error:function(data){
                        console.log('error===>',data)
                    }
                });
        }

        function ModificarCargo(cargo){
            
            $.ajax({              
                url: "{{  route('cargo.update') }}",
                type: 'POST',
                data: cargo,
                datatype: 'JSON',
                success:function(data){ 
                                  
                        if(data){MensajeCorrecto('Bien!', 'Cargo actualizado correctamente')}                       
                        _tblCargo.ajax.reload();
                    },
                    error:function(data){
                        console.log('error===>',data)
                    }
                });
        }

        function LimpiarFormulario(){
            $("#accion").val('')
            $("input[name=usuario]").val('')
            $("input[name=password]").val('')
            $("input[name=nombres]").val('')
            $("input[name=dni]").val('')
            $("input[name=correo]").val('')
            $("input[name=telefono]").val('')
            $("textarea[name=direccion]").val('')
            $("input[name=vigencia]").prop("checked",true)
            $("cmbCargo").val(0)

            $("input[name=maestro]").prop("checked",false);
            $.uniform.update('input[name=maestro]');

            if($("#divmaestro").hasClass("visible")){
             $("#divmaestro").removeClass("visible").addClass("invisible");
            }else{
              if(!$("#divmaestro").hasClass("invisible")){
                 $("#divmaestro").addClass("invisible");  
              }
            }
        }

        function LimpiarFormularioCargo(){
            $("#accioncargo").val('')
            $("input[name=nombrecargo]").val('')           
        }

        function ObtenerWorker(id){
            $.ajax({              
                url: "{{  route('worker.only') }}",
                type: 'GET',
                data: { 'id':id},
                datatype: 'JSON',
                success:function(data){                       
                                            
                    $("#accion").val('modificar')
                    $("#id").val(data[0].id)
                    $("input[name=usuario]").val(data[0].usuario)
                    $("input[name=password]").val(data[0].password)
                    $("input[name=nombres]").val(data[0].nombre)
                    $("input[name=dni]").val(data[0].dni)
                    $("input[name=correo]").val(data[0].correo)
                    $("input[name=telefono]").val(data[0].telefono)
                    $("textarea[name=direccion]").val(data[0].direccion)

                    if(data[0].idcargo == null){
                        $("#cmbCargo").val(0).trigger('change')
                    }else{
                        $("#cmbCargo").val(data[0].idcargo).trigger('change')
                    }

                    if(data[0].passwordmaestro == null){
                        $('input[name=maestro]').prop('checked',false);
                        $("#divmaestro").removeClass("visible").addClass("invisible");
                    }else{
                        $("input[name=maestro]").prop("checked",true);
                        $("#divmaestro").removeClass("invisible").addClass("visible");
                    }
                    
                    $.uniform.update('input[name=maestro]');

                    $("input[name=passwordmaestro]").val(data[0].passwordmaestro)
                    var valor = true;
                    if(data[0].vigencia == 1){ valor = true; }else{valor = false;}
                     
                    $("input[name=vigencia]").prop("checked",valor)
                    $.uniform.update('input[name=vigencia]');
                    
                    },
                    error:function(data){
                        console.log(data);
                    }
             });
        }
        function ObtenerCargo(id){
            $.ajax({              
                url: "{{  route('cargo.only') }}",
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

});

</script>

 @endsection

