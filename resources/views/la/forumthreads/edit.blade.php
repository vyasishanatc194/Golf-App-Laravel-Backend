@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/forumthreads') }}">Forumthread</a> :
@endsection
@section("contentheader_description", $forumthread->$view_col)
@section("section", "Forumthreads")
@section("section_url", url(config('laraadmin.adminRoute') . '/forumthreads'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Forumthreads Edit : ".$forumthread->$view_col)

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row mb-5">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
						{!! Form::model($forumthread, ['route' => [config('laraadmin.adminRoute') . '.forumthreads.update', $forumthread->id ], 'method'=>'PUT', 'id' => 'forumthread-edit-form']) !!}
							@la_form($module)
							
							{{--
							@la_input($module, 'author_id')
							@la_input($module, 'title')
							@la_input($module, 'content')
							@la_input($module, 'enable_threads')
							@la_input($module, 'total_likes')
							@la_input($module, 'total_comments')
							@la_input($module, 'total_posts')
							@la_input($module, 'private')
							@la_input($module, 'image_path')
							@la_input($module, 'category_id')
							--}}
							<br>
							<div class="form-group">
								{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/forumthreads') }}">Cancel</a></button>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#forumthread-edit-form").validate({
		
	});
});
</script>
@endpush
