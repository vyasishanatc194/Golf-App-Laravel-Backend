@extends("la.layouts.app")

<?php
use Dwij\Laraadmin\Models\Module;
?>

@section("contentheader_title", "Modules")
@section("contentheader_description", "modules listing")
@section("section", "Modules")
@section("sub_section", "Listing")
@section("htmlheader_title", "Modules Listing")

@section("headerElems")
<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Module</button>
@endsection

@section("main-content")

<div class="row mb-5">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<table id="dt_modules" class="table table-bordered">
				<thead>
				<tr class="table-success">
					<th>ID</th>
					<th>Name</th>
					<th>Table</th>
					<th>Items</th>
					<th>Actions</th>
				</tr>
				</thead>
				<tbody>
					
					@foreach ($modules as $module)
						<tr>
							<td>{{ $module->id }}</td>
							<td><a href="{{ url(config('laraadmin.adminRoute') . '/modules/'.$module->id) }}">{{ $module->name }}</a></td>
							<td>{{ $module->name_db }}</td>
							<td>{{ Module::itemCount($module->name) }}</td>
							<td>
								<a href="{{ url(config('laraadmin.adminRoute') . '/modules/'.$module->id)}}#fields" class="btn btn-primary btn-sm" style="display:inline;"><i class="fa fa-edit"></i></a>
								<a href="{{ url(config('laraadmin.adminRoute') . '/modules/'.$module->id)}}#access" class="btn btn-warning btn-sm" style="display:inline;"><i class="fa fa-key"></i></a>
								<a href="{{ url(config('laraadmin.adminRoute') . '/modules/'.$module->id)}}#sort" class="btn btn-success btn-sm" style="display:inline;"><i class="fa fa-sort"></i></a>
								<a module_name="{{ $module->name }}" module_id="{{ $module->id }}" class="btn btn-danger btn-sm delete_module" style="display:inline;"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					@endforeach
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Add Module</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				
			</div>
			{!! Form::open(['route' => config('laraadmin.adminRoute') . '.modules.store', 'id' => 'module-add-form']) !!}
			<div class="modal-body">
				<div class="card-body">
					<div class="form-group">
						<label for="name">Module Name :</label>
						{{ Form::text("name", null, ['class'=>'form-control', 'placeholder'=>'Module Name', 'data-rule-minlength' => 2, 'data-rule-maxlength'=>20, 'required' => 'required']) }}
					</div>
					<div class="form-group">
						<label for="icon">Icon</label>
						<div class="input-group">
							<input class="form-control" placeholder="FontAwesome Icon" name="icon" type="text" value="fa-cube"  data-rule-minlength="1" required>
							<span class="input-group-addon"></span>
						</div>
					</div>
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

<!-- module deletion confirmation  -->
<div class="modal" id="module_delete_confirm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Module Delete</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				
			</div>
			<div class="modal-body">
				<p>Do you really want to delete module <b id="moduleNameStr" class="text-danger"></b> ?</p>
				<p>Following files will be deleted:</p>
				<div id="moduleDeleteFiles"></div>
				<p class="text-danger">Note: Migration file will not be deleted but modified.</p>
			</div>
			<div class="modal-footer">
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.modules.destroy', 0], 'id' => 'module_del_form', 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-danger btn-delete pull-left" type="submit">Yes</button>
				{{ Form::close() }}
				<a data-dismiss="modal" class="btn btn-default pull-right" >No</a>				
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
@endsection

@push('styles')


@endpush
@push('scripts')
<script>
$(function () {
	$('.delete_module').on("click", function () {
    	var module_id = $(this).attr('module_id');
		var module_name = $(this).attr('module_name');
		$("#moduleNameStr").html(module_name);
		$url = $("#module_del_form").attr("action");
		$("#module_del_form").attr("action", $url.replace("/0", "/"+module_id));
		$("#module_delete_confirm").modal('show');
		$.ajax({
			url: "{{ url(config('laraadmin.adminRoute') . '/get_module_files/') }}/" + module_id,
			type:"POST",
			beforeSend: function() {
				$("#moduleDeleteFiles").html('<center><i class="fa fa-refresh fa-spin"></i></center>');
			},
			headers: {
		    	'X-CSRF-Token': '{{ csrf_token() }}'
    		},
			success: function(data) {
				var files = data.files;
				var filesList = "<ul>";
				for ($i = 0; $i < files.length; $i++) { 
					filesList += "<li>" + files[$i] + "</li>";
				}
				filesList += "</ul>";
				$("#moduleDeleteFiles").html(filesList);
			}
		});
	});
	
	$('input[name=icon]').iconpicker();
	$("#dt_modules").DataTable({
		
	});
	$("#module-add-form").validate({
		
	});
});
</script>
@endpush
