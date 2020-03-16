@if(Session::get('valido_session'))
<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

	<!-- Sidebar mobile toggler -->
	<div class="sidebar-mobile-toggler text-center">
		<a href="#" class="sidebar-mobile-main-toggle">
			<i class="icon-arrow-left8"></i>
		</a>
		Navigation
		<a href="#" class="sidebar-mobile-expand">
			<i class="icon-screen-full"></i>
			<i class="icon-screen-normal"></i>
		</a>
	</div>
	<!-- /sidebar mobile toggler -->


	<!-- Sidebar content -->
	<div class="sidebar-content">

		<!-- User menu -->
		<div class="sidebar-user">
			<div class="card-body">
				<div class="media">
					<div class="mr-3">
						<a href="#"><img src="images/demo/users/face11.jpg" width="38" height="38" class="rounded-circle" alt=""></a>
					</div>

					<div class="media-body">
						<div class="media-title font-weight-semibold">{{Session::get('user')}}</div>						
					</div>

					<div class="ml-3 align-self-center">
						<a href="#" class="text-white"><i class="icon-cog3"></i></a>
					</div>
				</div>
			</div>
		</div>
		<!-- /user menu -->


		<!-- Main navigation -->
		<div class="card card-sidebar-mobile">
			<ul class="nav nav-sidebar" data-nav-type="accordion">

				<!-- Main -->
				<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">MENU</div> <i class="icon-menu" title="Main"></i></li>
			<?php $auxMenu = ''; ?>
			@foreach(Session::get('menu') as $m)
				@if($m->menu != $auxMenu)												
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link"><i class="icon-color-sampler"></i> <span>{{$m->menu}}</span></a>
					<ul class="nav nav-group-sub" data-submenu-title="LISTA">
						<?php $i = 0; ?>
						@foreach(Session::get('menu') as $item)
							@if($item->menu == $m->menu && $item->submenu !='INICIO')
								 @if ($i == 0)
								 	<li class="nav-item"><a href="{{ action($item->ruta) }}" class="nav-link active">{{$item->submenu}}</a></li>
								 @else
					                <li class="nav-item"><a href="{{ action($item->ruta) }}" class="nav-link ">{{$item->submenu}}</a></li>                
					             @endif
								
								<?php $i++; ?>
							@endif
						@endforeach
						<!-- <li class="nav-item"><a href="{{ $item->ruta }}" class="nav-link">PROVEEDOR</a></li>
						<li class="nav-item"><a href="{{ action('ProveedorController@index') }}" class="nav-link">ASISTENCIA</a></li>
						<li class="nav-item"><a href="{{ url('cliente') }}" class="nav-link">USUARIO</a></li> -->
						
					</ul>
				</li>
				 <?php $auxMenu = $m->menu; ?>
				@endif
			@endforeach												
				<!-- /main -->
			</ul>
		</div>
		<!-- /main navigation -->

	</div>
	<!-- /sidebar content -->
	
</div>
<!-- /main sidebar -->
@endif