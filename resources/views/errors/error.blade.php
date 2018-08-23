<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
	@include('la.layouts.partials.htmlheader')
@show
<body>
    <div class="container-fluid">
		<div class="row">
			<div class="right-column">
				<main class="main-content p-5" role="main">
					<div class="row">
						<div class="col-md-12 my-5 text-center">
							<div class="text-danger">
                            <i class="fa fa-bug" style="font-size:120px;color:#FF5959;margin-bottom:30px;"></i>
							</div>
							<h1 class="display-1">{{ $title }}</h1>
							<div class="display-4 mb-3">
                                {!! $message !!}
                            </div>
							<div class="lead mt-5">
                                @if(Auth::guest())
                                    <a href="{{ url('/') }}">Homepage</a> | 
                                    <a href="javascript:history.back()">Go Back</a>
                                @else
                                    <a href="{{ url(config('laraadmin.adminRoute')) }}">Dashboard.</a> | 
                                    <a href="javascript:history.back()">Go Back</a>
                                @endif
                            </div>
						</div>
					</div>
				</main>
			</div>
		</div>
	</div>		
<!-- ./wrapper -->
@section('scripts')
	@include('la.layouts.partials.scripts')
@show

</body>
</html>