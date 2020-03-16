@extends('principal')

@section('scripts')
    <script src="{{asset('js/global_assets/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/tables/datatables/extensions/fixed_columns.min.js')}}"></script>

    <script src="{{asset('js/global_assets/plugins/extensions/jquery_ui/interactions.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('js/global_assets/demo_pages/form_select2.js')}}"></script>
   
    <script src="{{asset('js/global_assets/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/forms/styling/switchery.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/forms/styling/switch.min.js')}}"></script>
    <script src="{{asset('js/global_assets/demo_pages/form_checkboxes_radios.js')}}"></script>

    <script src="{{asset('js/global_assets/demo_pages/datatables_extension_fixed_columns.js')}}"></script>
   
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
        <div class="card-body" id="cardAgregarProveedor">
            <div class="text-left">
                <button type="submit" name="agregar" class="btn btn-primary">Agregar Nuevo Usuario <i class="icon-file-plus ml-2"></i></button>
            </div>
        </div>
    </div>


    <!-- Multiple fixed columns -->
    <div class="card">
        <table id="tblWorker" class="table" width="100%">
            <thead>
                <tr>
                    <th>Usuario</th>
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
                { "data": "nombre" },
                {
                   "data": 'id',
                   "render": function (id) {
                        var Permisos = "<button type='button' name="+id+" class='btn btn-primary rounded-round'><i class='icon-compose'></i></button>";
                        var btnActulizar = "<button type='button' name="+id+" class='btn btn-primary rounded-round'><i class='icon-compose'></i></button>";
                       return  btnActulizar;
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
            

            var objusuario = {usuario:usuario, password:password, nombres:nombres, dni:dni, correo:correo, telefono:telefono, direccion: direccion, vigencia:vigencia, id: id}

        
            if(accion == "registrar"){
                RegistrarWorker(objusuario)
            }else if(accion == "modificar"){
                ModificarWorker(objusuario)
            } 

            $("#cardFormularioWorker").css("display", "none")
            $("#cardAgregarWorker").css("display", "inline")
            LimpiarFormulario();

        });

        $('input[name=maestro]').change(function() {
            if(this.checked) {
               $("#divmaestro").removeClass("invisible").addClass("visible");
            }else{
               $("#divmaestro").removeClass("visible").addClass("invisible");
            }              
        });

        $('#tblWorker tbody').on( 'click','button.btn-danger', function () {
             var id = $(this)[0].name
             console.log(id)
             EliminarWorker(id)
        });

        $('#tblWorker tbody').on( 'click','button.btn-primary', function () {
             var id = $(this)[0].name          
             ObtenerWorker(id)
             $("#cardFormularioWorker").css("display", "inline")
             $("#cardAgregarWorker").css("display", "none")
        });

        $("button[name=agregar]").click(function(){
             $("#accion").val("registrar")
             $("#cardFormularioWorker").css("display", "inline")
             $("#cardAgregarWorker").css("display", "none")
        });

        $("button[name=cancelar]").click(function(){
            LimpiarFormulario()
             $("#cardFormularioWorker").css("display", "none")
             $("#cardAgregarWorker").css("display", "inline")
        });

        
       
        function RegistrarWorker(objusuario){
                console.log(objusuario)
            $.ajax({
                url: "{{  route('worker.save') }}",
                type: 'POST',
                data: objusuario,
                datatype: 'JSON',
                success:function(data){
                    console.log('ver===>',data)
                        if(data){alert('Usuario Registrado')}
                        _tblWorker.ajax.reload();
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
                        console.log(data)
                         if(data){alert('Usuario Eliminado')}
                         _tblWorker.ajax.reload();
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
                console.log('ver===>',data)                  
                        if(data){alert('Usuario Modificado')}                       
                        _tblWorker.ajax.reload();
                    },
                    error:function(data){
                        console.log('error===>',data)
                    }
                });
        }

        function LimpiarFormulario(){
            $("input[name=usuario]").val('')
            $("input[name=password]").val('')
            $("input[name=nombres]").val('')
            $("input[name=dni]").val('')
            $("input[name=correo]").val('')
            $("input[name=telefono]").val('')
            $("textarea[name=direccion]").val('')
            $("input[name=vigencia]").prop("checked",true)
           
        }

        function ObtenerWorker(id){
            $.ajax({              
                url: "{{  route('worker.only') }}",
                type: 'GET',
                data: { 'id':id},
                datatype: 'JSON',
                success:function(data){                       
                        console.log(data);                        
                     $("#accion").val('modificar')
                     $("#id").val(data[0].id)
                     $("input[name=usuario]").val(data[0].usuario)
                    $("input[name=password]").val(data[0].password)
                    $("input[name=nombres]").val(data[0].nombre)
                    $("input[name=dni]").val(data[0].dni)
                    $("input[name=correo]").val(data[0].correo)
                    $("input[name=telefono]").val(data[0].telefono)
                    $("textarea[name=direccion]").val(data[0].direccion)
                    var valor = true;
                    if(data[0].vigencia == 1){ valor = true; }else{valor = false;}
                     
                    $("input[name=vigencia]").prop("checked",valor)
                    


                    },
                    error:function(data){
                        console.log(data);
                    }
             });
        }

});

</script>

 @endsection

