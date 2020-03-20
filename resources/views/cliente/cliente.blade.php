@extends('principal')

@section('scripts')
    <script src="{{asset('js/global_assets/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/tables/datatables/extensions/fixed_columns.min.js')}}"></script>

    <script src="{{asset('js/global_assets/plugins/notifications/sweet_alert.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>

    <script src="{{asset('js/global_assets/plugins/extensions/jquery_ui/interactions.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('js/global_assets/demo_pages/form_select2.js')}}"></script>
    
    <!-- <script src="{{asset('js/global_assets/plugins/forms/styling/uniform.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/forms/styling/switchery.min.js')}}"></script>
    <script src="{{asset('js/global_assets/plugins/forms/styling/switch.min.js')}}"></script>
    <script src="{{asset('js/global_assets/demo_pages/form_checkboxes_radios.js')}}"></script> -->

    <script src="{{asset('js/global_assets/demo_pages/datatables_extension_fixed_columns.js')}}"></script>

    <script src="{{asset('js/global_assets/demo_pages/extra_sweetalert.js')}}"></script>
   
@stop


@section('content')
<div class="content">
    <div class="card" >
   
        <div class="card-body" id="cardFormularioCliente" style="display: none">
                <input type="hidden" value="" id="accion"> 
                <input type="hidden" value="" id="id"> 
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
                            <input type="text" name="nombres" class="form-control" placeholder="Ingresar Programacion Visita">
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


<!-- Multiple fixed columns -->
    <div class="card"> 
        <table id="tblCliente" class="table" width="100%">
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
                { "data": "departamento" },
                { "data": "provincia" },
                { "data": "distrito" },                
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
            var nombres = $("input[name=nombres]").val()
            var departamento = $("#cmbDepartamento").val()
            var provincia = $("#cmbProvincia").val()
            var distrito = $("#cmbDistrito").val()
            var telefono = $("input[name=telefono]").val()
            var direccion = $("textarea[name=direccion]").val()

            var cliente = {name:nombres, iddepartment:departamento, idprovince:provincia, iddistrict:distrito, addres:direccion, phone:telefono, id: id}


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
             EliminarCliente(id)   
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

        //LISTA PUBLICIDAD
        $.ajax({    
            type: 'GET',
            url: "{{  route('publicidad.list') }}",
            datatype: 'JSON',
            success:function(data){

                var lista = [];

                $.each(data, function (i, data) {
                    var option = {id:data.id,text:data.nombre}
                    lista[i] = option
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

                $.each(data, function (i, data) {
                    var option = {id:data.id,text:data.nombre}
                    lista[i] = option
                });
                
                $('#cmbTipoCliente').select2({ data: lista });
                
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

        function RegistrarCliente(cliente){

            $.ajax({              
                url: "{{  route('client.save') }}",
                type: 'POST',
                data: cliente,
                datatype: 'JSON',
                success:function(data){                   
                        if(data){alert('Cliente Registrado')}                       
                        _tblCliente.ajax.reload();
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
                        if(data){alert('Cliente Modificado')}                       
                        _tblCliente.ajax.reload();
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
                        console.log(data)               
                         if(data){alert('Cliente Eliminado')}                       
                         _tblCliente.ajax.reload();
                    },
                    error:function(data){
                        console.log(data);
                    }
                });
        }

        function ActualizarCliente(id){

            $.ajax({              
                url: "{{  route('client.delete') }}",
                type: 'POST',
                data: {id:id},
                datatype: 'JSON',
                success:function(data){  
                        console.log(data)               
                         if(data){alert('Cliente Eliminado')}                       
                         _tblCliente.ajax.reload();
                    },
                    error:function(data){
                        console.log(data);
                    }
                });
        }

        function LimpiarFormulario(){
            $("#accion").val('')
             $("input[name=nombres]").val('')
             $("#cmbDepartamento").val(1).trigger('change')
             getProvince(1)
             getDistrict(1,101)
             $("input[name=telefono]").val('')
             $("textarea[name=direccion]").val('')
        }

        function ObtenerCliente(id){
            $.ajax({              
                url: "{{  route('client.only') }}",
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
                     $("input[name=telefono]").val(data[0].telefono)
                     $("textarea[name=direccion]").val(data[0].direccion)

                    },
                    error:function(data){
                        console.log(data);
                    }
             });
        }

});

    

</script>

 @endsection
