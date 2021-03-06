@extends("la.layouts.app")

@section("contentheader_title", "Courses")
@section("contentheader_description", "Courses listing")
@section("section", "Courses")
@section("sub_section", "Listing")
@section("htmlheader_title", "Courses Listing")

@section("headerElems")
@la_access("Courses", "create")
<button class="btn btn-success btn-sm pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/courses/create') }}">Add Course</a></button>
@endla_access
@endsection

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
				<table id="example1" class="table table-bordered">
					<thead>
					<tr class="table-success">
						@foreach( $listing_cols as $col )
						<th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
						@endforeach
						@if($show_actions)
						<th>Actions</th>
						@endif
					</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>		

@la_access("Courses", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Add Course</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			{!! Form::open(['action' => 'LA\CoursesController@store', 'id' => 'course-add-form']) !!}
			<div class="model-body">
				<div class="card-body">
                    @la_form($module)
					
					{{--
					@la_input($module, 'description')
					@la_input($module, 'name')
					@la_input($module, 'academy_id')
					@la_input($module, 'featureimage')
					@la_input($module, 'content')
					@la_input($module, 'modules_ids')
					@la_input($module, 'course_chapters')
					@la_input($module, 'course_skills')
					@la_input($module, 'course_video')
					--}}
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endla_access

@endsection

@push('scripts')

<script>
$(function () {
	$("#example1").DataTable({
		processing: false,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/course_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#course-add-form").validate({
		
	});
});
</script>
@endpush
