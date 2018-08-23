@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/forumcategories') }}">ForumCategory</a> :
@endsection
@section("contentheader_description", $forumcategory->$view_col)
@section("section", "ForumCategories")
@section("section_url", url(config('laraadmin.adminRoute') . '/forumcategories'))
@section("sub_section", "Edit")

@section("htmlheader_title", "ForumCategories Edit : ".$forumcategory->$view_col)

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

{{-- <div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($forumcategory, ['route' => [config('laraadmin.adminRoute') . '.forumcategories.update', $forumcategory->id ], 'method'=>'PUT', 'id' => 'forumcategory-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'title')
					@la_input($module, 'description')
					@la_input($module, 'enable_threads')
					@la_input($module, 'thread_count')
					@la_input($module, 'post_count')
					@la_input($module, 'private')
					--}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/forumcategories') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div> --}}

<div class="row mb-5">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        {!! Form::model($forumcategory, ['route' => [config('laraadmin.adminRoute') . '.forumcategories.update', $forumcategory->id ], 'method'=>'PUT', 'id' => 'forumcategory-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'title')
					@la_input($module, 'description')
					@la_input($module, 'enable_threads')
					@la_input($module, 'thread_count')
					@la_input($module, 'post_count')
					@la_input($module, 'private')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/forumcategories') }}">Cancel</a></button> 
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
	$("#forumcategory-edit-form").validate({
		
	});
});
</script>
@endpush
