@extends('la.layouts.app')

@section('htmlheader_title')
    Page not found
@endsection

@section('contentheader_title')
    404 Error Page
@endsection

@section('$contentheader_description')
@endsection

@section('main-content')

    <div class="row">
		<div class="col-md-12 my-5 text-center">
			<div class="text-danger">
				<i class="batch-icon batch-icon-link-alt batch-icon-xxl"></i>
				<i class="batch-icon batch-icon-search batch-icon-xxl"></i>
				<i class="batch-icon batch-icon-link-alt batch-icon-xxl"></i>
			</div>
			<h1 class="display-1">404</h1>
			<div class="display-4 mb-3">Page Not Found</div>
			<div class="lead">We can't find the page you are looking for.</div>
			<div class="lead">Try searching for it using the search field below or you can go <a href="index.html">back to our homepage</a>.</div>
		</div>
	</div>
	<div class="row mb-5 justify-content-center">
		<div class="col-md-6">
			<form class="my-2 my-lg-0 no-waves-effect">
				<div class="input-group mb-3">
					<input type="text" class="form-control" placeholder="Search for..." aria-label="Search for..." aria-describedby="basic-addon2">
						<div class="input-group-append">
							<button class="btn btn-primary btn-gradient waves-effect waves-light" type="button">Search</button>
						</div>
				</div>
			</form>
		</div>
	</div>
@endsection