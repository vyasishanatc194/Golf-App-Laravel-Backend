@extends("la.layouts.app")

@section('main-content')
 



<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
            <button class="btn btn-success btn-sm pull-right"><a href="{{url('/')}}/admin/forums/create" />Add Forum</a></button>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Titls</th>
                                <th>Content</th>
                                <th>Category</th>
                                <th>Total likes</th>
                                <th>Total Comments</th>
                                <th>Total Posts</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
{{--                             
                        @foreach($module as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->content }}</td>
                                <td>
                                    <a href="{{ url('/admin/forums/' . $item->id . '/edit') }}" class="btn btn-primary btn-sm" title="Edit Forum"><span class="fa fa-pencil" aria-hidden="true"/></a>
                                    {!! Form::open([
                                        'method'=>'DELETE',
                                        'id'=>'DELETE_'.$item->id,
                                        'url' => ['/admin/forums/', $item->id],
                                        'style' => 'display:inline'
                                    ]) !!}
                                        {!! Form::button('<span class="fa fa-trash" aria-hidden="true" title="Delete Forum" />', array(
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-sm',
                                                'title' => 'Delete Forum',
                                                'onclick'=>'return myFunction('.$item->id.')'
                                        ));!!}
                                    {!! Form::close() !!}</td>
                            </tr>
                        @endforeach --}}
                        </tbody>
                    </table>
                    
                </div>
            </div>   
        </div>   
    </div> 
</div>                                          
@endsection

@push('scripts')

<script>
    var url = "{{url(config('laraadmin.adminRoute') . '/forums/')}}";
$(function () {
	$("#example1").DataTable({
		processing: false,
        serverSide: true,
        "aaSorting": [],
        ajax: "{{ url(config('laraadmin.adminRoute') . '/forum_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
        columns:[
            {
                data: 'id', name: 'forum_threads.id',"searchable": false
            },
            {
                data: 'title', name: 'forum_threads.title',
            },
            {
                data: 'content', name: 'forum_threads.content',
            },
            {
                data: 'categoryname', name: 'forum_categories.title',"searchable": false
            },
            {
                data: 'total_likes', name: 'forum_threads.total_likes',"searchable": false
            },
            {
                data: 'total_comments', name: 'forum_threads.total_comments',"searchable": false
            },
            {
                data: 'total_posts', name: 'forum_threads.total_posts',"searchable": false
            },
            {
                data: null, 
                "searchable": false,
                "orderable": false,
                render:function(o){
                    var edit = '';
                    edit =  '<a href="'+url+'/'+o.id+'/edit" class="btn btn-warning btn-sm" style="display:inline;"><i class="fa fa-edit"></i></a>';
                    return edit;
                }
            }

        ]
		
		//columnDefs: [ { orderable: false, targets: [-1] }],
		
	});
	$("#course-add-form").validate({
		
	});
});
</script>
@endpush

