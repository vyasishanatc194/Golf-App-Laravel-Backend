@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/forum_comments') }}">Forum Comment</a> :
@endsection
@section("contentheader_description", $forum_comment->$view_col)
@section("section", "Forum Comments")
@section("section_url", url(config('laraadmin.adminRoute') . '/forum_comments'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Forum Comments Edit : ".$forum_comment->$view_col)

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
				{!! Form::model($forum_comment, ['route' => [config('laraadmin.adminRoute') . '.forum_comments.update', $forum_comment->id ], 'method'=>'PUT', 'id' => 'forum_comment-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'user_id')
					@la_input($module, 'post_id')
					@la_input($module, 'body')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/forum_comments') }}">Cancel</a></button>
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
	$("#forum_comment-edit-form").validate({
		
	});
});
</script>
@endpush
