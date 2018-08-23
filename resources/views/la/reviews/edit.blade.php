@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/reviews') }}">Reviews</a> :
@endsection
@section("contentheader_description", $reviews->$view_col)
@section("section", "Reviews")
@section("section_url", url(config('laraadmin.adminRoute') . '/reviews'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Reviews Edit : ".$reviews->$view_col)

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

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($reviews, ['route' => [config('laraadmin.adminRoute') . '.reviews.update', $reviews->id ], 'method'=>'PUT', 'id' => 'review-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'name')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/reviews') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#reviews-edit-form").validate({
		
	});
});
</script>
@endpush
