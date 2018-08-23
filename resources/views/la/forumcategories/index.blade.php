@extends("la.layouts.app")

@section("contentheader_title", "ForumCategories")
@section("contentheader_description", "ForumCategories listing")
@section("section", "ForumCategories")
@section("sub_section", "Listing")
@section("htmlheader_title", "ForumCategories Listing")

@section("headerElems")
@la_access("ForumCategories", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add ForumCategory</button>
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

{{-- <div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
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
</div> --}}
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

@la_access("ForumCategories", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add ForumCategory</h4>
			</div>
			{!! Form::open(['action' => 'LA\ForumCategoriesController@store', 'id' => 'forumcategory-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    @la_form($module)
					
					{{--
					@la_input($module, 'title')
					@la_input($module, 'description')
					@la_input($module, 'enable_threads')
					@la_input($module, 'thread_count')
					@la_input($module, 'post_count')
					@la_input($module, 'private')
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

@push('styles')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/> --}}
@endpush

@push('scripts')
{{-- <script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script> --}}
<script>
$(function () {
	$("#example1").DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/forumcategory_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#forumcategory-add-form").validate({
		
	});
});
</script>
@endpush
