@extends("la.layouts.app")

@section("contentheader_title", "Forum Posts")
@section("contentheader_description", "Forum Posts listing")
@section("section", "Forum Posts")
@section("sub_section", "Listing")
@section("htmlheader_title", "Forum Posts Listing")

@section("headerElems")
@la_access("Forum_Posts", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Forum Post</button>
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

@la_access("Forum_Posts", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Forum Post</h4>
			</div>
			{!! Form::open(['action' => 'LA\Forum_PostsController@store', 'id' => 'forum_post-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    @la_form($module)
					
					{{--
					@la_input($module, 'thread_id')
					@la_input($module, 'author_id')
					@la_input($module, 'content')
					@la_input($module, 'total_likes')
					@la_input($module, 'total_comments')
					@la_input($module, 'title')
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
        //ajax: "{{ url(config('laraadmin.adminRoute') . '/forum_post_dt_ajax') }}",
		ajax : {
			url: "{{ url(config('laraadmin.adminRoute') . '/forum_post_dt_ajax') }}", // json datasource
			type: "get", // method , by default get
			data: function (d) {
				d.threadId = '{{$threadId}}';
			}
		},
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#forum_post-add-form").validate({
		
	});
});
</script>
@endpush
