@extends("la.layouts.app")

@section("contentheader_title", "Academies")
@section("contentheader_description", "Academies listing")

@section("sub_section", "Listing")
@section("htmlheader_title", "Academies Listing")

@section("headerElems")
<style>
.headerElems{
	    display: block;
    margin-top: -28px;
    position: relative;
    padding: 0 0 18px 0;
    float:none;
}
</style>
@la_access("Academies", "create")
    <div class="tab pull-left" style="margin-top:32px;">
  <button class="tablinks btn btn-primary btn-gradient waves-effect waves-light active" onclick="openLearning(event, 'Academy')">Academies</button>
  <button class="tablinks btn btn-primary btn-gradient waves-effect waves-light" onclick="openLearning(event, 'Course')">Courses</button>
  <button class="tablinks btn btn-primary btn-gradient waves-effect waves-light " onclick="openLearning(event, 'UniModule')">UniModules</button> 
  <button class="tablinks btn btn-primary btn-gradient waves-effect waves-light" onclick="openLearning(event, 'Videos')">Videos</button> 
</div>


	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Academy</button>
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

@la_access("Academies", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Add Academy</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			{!! Form::open(['action' => 'LA\AcademiesController@store', 'id' => 'academy-add-form']) !!}
			<div class="modal-body">
				<div class="card-body">
                    @la_form($module)
					
					{{--
					@la_input($module, 'name')
					@la_input($module, 'address')
					@la_input($module, 'phone')
					@la_input($module, 'dec')
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
        ajax: "{{ url(config('laraadmin.adminRoute') . '/academy_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#academy-add-form").validate({
		
	});
});
function openLearning(evt, learningName) {
		if(learningName == "Academy") {	
			window.location.href = "{{ url(config('laraadmin.adminRoute') . '/academies') }}";
		} else if(learningName == "Course") {
			window.location.href = "{{ url(config('laraadmin.adminRoute') . '/courses') }}";
		} else if(learningName == "UniModule") {
			window.location.href = "{{ url(config('laraadmin.adminRoute') . '/unimodules') }}";
		}else if(learningName == "Videos") {
			window.location.href = "{{ url(config('laraadmin.adminRoute') . '/videos') }}";
		}
	}
</script>
@endpush
