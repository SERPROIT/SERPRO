@extends('principal')

@section('scripts')
    <script src="{{asset('js/global_assets/plugins/forms/styling/uniform.min.js')}}"></script>
	<script src="{{asset('js/global_assets/demo_pages/login.js')}}"></script>
@stop


@section('content')
<div class="content d-flex justify-content-center align-items-center">

	<!-- Login card -->
	<div class="login-form">
		<div class="card mb-0">
			<div class="card-body">
				<div class="text-center mb-3">
					<i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
					<h5 class="mb-0">Inicio de Sesión</h5>
					<span class="d-block text-muted">Tus credenciales</span>
				</div>

				<div class="form-group form-group-feedback form-group-feedback-left">
					<input type="text" class="form-control" name="usuario" placeholder="Usuario">
					<div class="form-control-feedback">
						<i class="icon-user text-muted"></i>
					</div>
					<label id="label_usuario" class="validation-invalid-label" for="switch_group"></label>
				</div>

				<div class="form-group form-group-feedback form-group-feedback-left">
					<input type="password" class="form-control" name="password" placeholder="Password">
					<div class="form-control-feedback">
						<i class="icon-lock2 text-muted"></i>
					</div>
					<label id="label_password" class="validation-invalid-label" for="switch_group"></label>
				</div>
				<span class="form-text text-danger text-center" id="message_error"></span>

				<!-- <div class="form-group d-flex align-items-center">
					<div class="form-check mb-0">
						<label class="form-check-label">
							<input type="checkbox" name="remember" class="form-input-styled" checked data-fouc>
							Remember
						</label>
					</div>

					<a href="login_password_recover.html" class="ml-auto">Forgot password?</a>
				</div> -->

				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block" name="ingresar">Ingresar<i class="icon-circle-right2 ml-2"></i></button>
				</div>
			</div>
		</div>
	</div>
	<!-- /login card -->

</div>

 <script>

    $(document).ready(function(){

    	$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    	$("button[name=ingresar]").click(function(){
           
            var _usuario = $("input[name=usuario]").val()
            var _password = $("input[name=password]").val()
           

            var usuario = {usuario:_usuario, password:_password}

            if(_usuario == ''){
            	if(!verClass('usuario')) {
            		$("#label_usuario").append('Ingresar usuario')
            		addClass('usuario')
            	}
            	          	
            }
            if(_password == ''){
            	if(!verClass('password')) {
            		$("#label_password").append('Ingresar password')
            		addClass('password')
            	}            					
            }
            if(verClass('usuario')==false && verClass('password') == false){            	           		
            		ValidarUsuario(usuario)	
            }

        });

        $("input[name=usuario]").keyup(function(){
		  $("#label_usuario").text('')
		  removeClass('usuario')
		});

		$("input[name=password]").keyup(function(){
		  $("#label_password").text('')
		  removeClass('password')
		});

   });

    function ValidarUsuario(usuario){
    	$.ajax({    
            type: 'GET',
            url: "{{  route('user.validate') }}",
            data: usuario,
            datatype: 'JSON',
            success:function(data){
            	console.log(data); 
            	//alert(data[0].usuario)
            	if(data.length == 0){
            		$("#message_error").text('')
            		$("#message_error").append('Credenciales incorrectas')	
            	}else{
            		$("#message_error").text('')
            		invokeClient()
            	}
				            
            },
            error:function(data){
                console.log(data);
            }
        });

    }

    function invokeClient(){
    	// console.log(data[0].usuario)
    	// sessionStorage.setItem("user", data[0].usuario);
		window.location.replace("/inicio");

    	// $.ajax({    
     //        type: 'GET',
     //        url: "{{ route('cliente.index') }}",
     //        datatype: 'JSON',
     //        success:function(data){
     //        	console.log(data); 				            
     //        },
     //        error:function(data){
     //            console.log(data);
     //        }
     //    });
    }

    function addClass(tipo){
    	$("input[name="+tipo+"]").addClass("required");
    }
    function removeClass(tipo){
    	$("input[name="+tipo+"]").removeClass("required");
    }

    function verClass(tipo){

    	if($("input[name="+tipo+"]").hasClass("required")){
    		return true;
    	}else{
    		return false;
    	}    	
    }

</script>

 @endsection