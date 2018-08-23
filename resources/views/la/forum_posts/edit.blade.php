@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/forum_posts') }}">Forum Post</a> :
@endsection
@section("contentheader_description", $forum_post->$view_col)
@section("section", "Forum Posts")
@section("section_url", url(config('laraadmin.adminRoute') . '/forum_posts'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Forum Posts Edit : ".$forum_post->$view_col)

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
				{!! Form::model($forum_post, ['route' => [config('laraadmin.adminRoute') . '.forum_posts.update', $forum_post->id ], 'method'=>'PUT', 'id' => 'forum_post-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'thread_id')
					@la_input($module, 'author_id')
					@la_input($module, 'content')
					@la_input($module, 'total_likes')
					@la_input($module, 'total_comments')
					@la_input($module, 'title')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/forum_posts') }}">Cancel</a></button>
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
	$("#forum_post-edit-form").validate({
		
	});
});
</script>
@endpush
