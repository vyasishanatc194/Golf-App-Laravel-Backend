<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
	@include('la.layouts.partials.htmlheader')
@show
<body >

	<div class="container-fluid">
		<div class="row" >
			@if(LAConfigs::getByKey('layout') != 'layout-top-nav')
				@include('la.layouts.partials.sidebar')
			@endif
			<div class="right-column">
				@include('la.layouts.partials.mainheader')
				<!-- Content Wrapper. Contains page content -->
				<main class="p-5" role="main">
						@if(LAConfigs::getByKey('layout') == 'layout-top-nav') 
						<div class="row"> @endif
						@if(!isset($no_header))
							@include('la.layouts.partials.contentheader')
						@endif
						<!-- Your Page Content Here -->
						@yield('main-content')	
						<!-- /.content -->
						@include('la.layouts.partials.footer')
						@if(LAConfigs::getByKey('layout') == 'layout-top-nav') </div> @endif
				</main><!-- /.content-wrapper -->
			</div>
		</div>
	</div>		

<!-- ./wrapper -->
@section('scripts')
	@include('la.layouts.partials.scripts')
@show

</body>
</html>
