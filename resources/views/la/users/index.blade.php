@extends("la.layouts.app")

@section("contentheader_title", "Users")
@section("contentheader_description", "Users listing")
@section("section", "Users")
@section("sub_section", "Listing")
@section("htmlheader_title", "Users Listing")

@section("headerElems")
@la_access("Users", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add User</button>
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

@la_access("Users", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Add User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			{!! Form::open(['action' => 'LA\UsersController@store', 'id' => 'user-add-form']) !!}
			<div class="modal-body">
				<div class="card-body">
                    @la_form($module)
					
					{{--
					@la_input($module, 'name')
					@la_input($module, 'context_id')
					@la_input($module, 'email')
					@la_input($module, 'password')
					@la_input($module, 'type')
					@la_input($module, 'notify_from')
					@la_input($module, 'image')
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
        ajax: "{{ url(config('laraadmin.adminRoute') . '/user_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#user-add-form").validate({
		
	});
});
</script>
@endpush
