@extends('la.layouts.app')

@section('htmlheader_title')
    Service unavailable
@endsection

@section('contentheader_title')
    503 Error Page
@endsection

@section('$contentheader_description')
@endsection

@section('main-content')
    <div class="container-fluid">
		<div class="row">
			<div class="right-column">
				<main class="main-content p-5" role="main">
					<div class="row">
						<div class="col-md-12 my-5 text-center">
							<div class="text-danger">
								<i class="batch-icon batch-icon-browser-close batch-icon-xxl"></i>
								<i class="batch-icon batch-icon-browser-close batch-icon-xxl"></i>
								<i class="batch-icon batch-icon-browser-close batch-icon-xxl"></i>
							</div>
							<h1 class="display-1">503</h1>
							<div class="display-4 mb-3">Server Error</div>
							<div class="lead">Oops! Something went wrong.</div>
							<div class="lead">Don't panic, just wait a bit then refresh.</div>
							<div class="lead">If you've already done that and this error still shows up, please email us at <a href="mailto:email@example.com">email@example.com</a>.</div>
							<div class="lead mt-5"><a href="{{ url('/home') }}"><i class="batch-icon batch-icon-arrow-left"></i> return to dashboard</a></div>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-12">
							<footer class="text-center">
								Powered by - <a href="http://base5builder.com/?click_source=quillpro_footer_link" target="_blank" style="font-weight:300;color:#ffffff;background:#1d1d1d;padding:0 3px;">Base<span style="color:#ffa733;font-weight:bold">5</span>Builder</a>
							</footer>
						</div>
					</div>
				</main>
			</div>
		</div>
	</div>
@endsection