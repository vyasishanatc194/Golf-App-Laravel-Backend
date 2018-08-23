@extends('la.layouts.app')

@section('htmlheader_title')
	Academy View
@endsection


@section('main-content')
<div id="page-content" >
	<div class="row mb-5">
		<div class="col-md-12">
			<div class="card bg-primary bg-gradient">
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-3">
									<!--<img class="profile-image" src="{{ asset('la-assets/img/avatar5.png') }}" alt="">-->
									<div class="profile-icon text-primary"><i class="fa {{ $module->fa_icon }}"></i></div>
								</div>
								<div class="col-md-9">
									<h4 class="name">{{ $academy->$view_col }}</h4>
									<div class="row stats">
										<div class="col-md-4"><i class="fa fa-facebook"></i> 234</div>
										<div class="col-md-4"><i class="fa fa-twitter"></i> 12</div>
										<div class="col-md-4"><i class="fa fa-instagram"></i> 89</div>
									</div>
									<p class="desc">Test Description in one line</p>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="dats1"><div class="label2">Admin</div></div>
							<div class="dats1"><i class="fa fa-envelope-o"></i> superadmin@gmail.com</div>
							<div class="dats1"><i class="fa fa-map-marker"></i> Pune, India</div>
						</div>
						<div class="col-md-3">
							<!--
							<div class="teamview">
								<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user1-128x128.jpg') }}" alt=""><i class="status-online"></i></a>
								<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user2-160x160.jpg') }}" alt=""></a>
								<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user3-128x128.jpg') }}" alt=""></a>
								<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user4-128x128.jpg') }}" alt=""><i class="status-online"></i></a>
								<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user5-128x128.jpg') }}" alt=""></a>
								<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user6-128x128.jpg') }}" alt=""></a>
								<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user7-128x128.jpg') }}" alt=""></a>
								<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user8-128x128.jpg') }}" alt=""></a>
								<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user5-128x128.jpg') }}" alt=""></a>
								<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user6-128x128.jpg') }}" alt=""><i class="status-online"></i></a>
								<a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user7-128x128.jpg') }}" alt=""></a>
							</div>
							-->
							<div class="dats1 pb">
								<div class="clearfix">
									<span class="pull-left">Task #1</span>
									<small class="pull-right">20%</small>
								</div>
								<div class="progress progress-xs active">
									<div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
										<span class="sr-only">20% Complete</span>
									</div>
								</div>
							</div>
							<div class="dats1 pb">
								<div class="clearfix">
									<span class="pull-left">Task #2</span>
									<small class="pull-right">90%</small>
								</div>
								<div class="progress progress-xs active">
									<div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 90%" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
										<span class="sr-only">90% Complete</span>
									</div>
								</div>
							</div>
							<div class="dats1 pb">
								<div class="clearfix">
									<span class="pull-left">Task #3</span>
									<small class="pull-right">60%</small>
								</div>
								<div class="progress progress-xs active">
									<div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 60%" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
										<span class="sr-only">60% Complete</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2 actions">
							@la_access("Academies", "edit")
								<a href="{{ url(config('laraadmin.adminRoute') . '/academies/'.$academy->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
							@endla_access
							
							@la_access("Academies", "delete")
								{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.academies.destroy', $academy->id], 'method' => 'delete', 'style'=>'display:inline']) }}
									<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
								{{ Form::close() }}
							@endla_access
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>	
	<div class="row mb-5">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">	
					<ul data-toggle="ajax-tab" class="nav nav-pills card-header-pills" role="tablist">
						<li class="nav-item"><a  class="nav-link" href="{{ url(config('laraadmin.adminRoute') . '/academies') }}" data-toggle="tooltip" data-placement="right" title="Back to Academies"><i class="fa fa-chevron-left"></i></a></li>
						<li class="nav-item"><a role="tab"  class="nav-link active show" data-toggle="tab" class="nav-link active show" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
						<li class="nav-item"><a role="tab" class="nav-link" data-toggle="tab" href="#tab-timeline" data-target="#tab-timeline"><i class="fa fa-clock-o"></i> Timeline</a></li>
					</ul>
				</div>	
				<div class="card-body">
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active fade in show" id="tab-info">
							<div class="tab-content">
								<div class="panel infolist">
									<div class="panel-default panel-heading">
										<h4>General Info</h4>
									</div>
									<div class="panel-body">
										@la_display($module, 'name')
										@la_display($module, 'address')
										@la_display($module, 'phone')
										@la_display($module, 'dec')
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade in  timeline" id="tab-timeline">
							<h2>2017</h2>
							<ul class="timeline-items">
								<li class="timeline-item animated fadeInLeft" style="animation-duration: 300ms;">
									<h3>Title</h3>
									<hr>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet cupiditate, delectus deserunt doloribus earum eveniet explicabo fuga iste magni maxime mollitia nemo neque, perferendis quod reprehenderit ut, vel veritatis voluptas?</p>
									<hr>
									<time>Date</time>
								</li>
								<li class="timeline-item inverted animated fadeInRight" style="animation-duration: 300ms;">
									<h3>Title</h3>
									<hr>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet cupiditate, delectus deserunt doloribus earum eveniet explicabo fuga iste magni maxime mollitia nemo neque, perferendis quod reprehenderit ut, vel veritatis voluptas?</p>
									<hr>
									<time>Date</time>
								</li>
							</ul>
							<h2>2018</h2>
							<ul class="timeline-items">
								<li class="timeline-item animated fadeInLeft" style="animation-duration: 300ms;">
									<h3>Title</h3>
									<hr>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aspernatur consequuntur culpa deserunt ea esse est inventore, ipsa laborum officia, quam quia quidem, rem sunt tempora tenetur ullam voluptatem.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta dolore harum iure quod ut! Accusamus aspernatur corporis est excepturi facere laudantium nesciunt nihil optio, quaerat quos rerum sunt suscipit voluptate?.</p>
									<hr>
									<time>Mars 2014</time>
								</li>
								<li class="timeline-item inverted animated fadeInRight" style="animation-duration: 300ms;">
									<h3>Title</h3>
									<hr>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aspernatur consequuntur culpa deserunt ea esse est inventore, ipsa laborum officia, quam quia quidem, rem sunt tempora tenetur ullam voluptatem.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta dolore harum iure quod ut! Accusamus aspernatur corporis est excepturi facere laudantium nesciunt nihil optio, quaerat quos rerum sunt suscipit voluptate?.</p>
									<hr>
									<time>Mars 2014</time>
								</li>
								<li class="is-hidden timeline-item centered">
									<h3>Title</h3>
									<hr>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, cupiditate dicta dignissimos dolorem doloribus ducimus eos error ex molestiae nobis odio odit optio placeat quasi repudiandae, unde velit voluptate voluptatem!
									</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab commodi consectetur cupiditate ea, eius excepturi expedita illum, incidunt ipsam iste modi obcaecati optio repellendus! Dolore dolores pariatur sint veniam voluptates!</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci consequatur distinctio doloremque eos eum eveniet fuga molestiae mollitia nesciunt nisi nobis nostrum, odio omnis pariatur praesentium quibusdam sequi sint voluptates.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquam, aspernatur commodi consequuntur corporis dicta, distinctio enim eos expedita, id iste laborum maxime nesciunt quaerat sed temporibus veniam vero voluptatem.</p>
									<p><a href="http://gamejolt.com/games/slender-the-cursed-forest/30950">Link</a>
									</p>
									<hr>
									<time>Date</time>
								</li>
								<li class="is-hidden timeline-item inverted">
									<h3>Title</h3>
									<hr>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aspernatur consequuntur culpa deserunt ea esse est inventore, ipsa laborum officia, quam quia quidem, rem sunt tempora tenetur ullam voluptatem.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta dolore harum iure quod ut! Accusamus aspernatur corporis est excepturi facere laudantium nesciunt nihil optio, quaerat quos rerum sunt suscipit voluptate?.</p>
									<hr>
									<time>Mars 2014</time>
								</li>
								<li class="is-hidden timeline-item">
									<h3>Title</h3>
									<hr>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aspernatur consequuntur culpa deserunt ea esse est inventore, ipsa laborum officia, quam quia quidem, rem sunt tempora tenetur ullam voluptatem.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta dolore harum iure quod ut! Accusamus aspernatur corporis est excepturi facere laudantium nesciunt nihil optio, quaerat quos rerum sunt suscipit voluptate?.</p>
									<hr>
									<time>Mars 2014</time>
								</li>
								<li class="is-hidden timeline-item centered">
									<h3>Title</h3>
									<hr>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis, cupiditate dicta dignissimos dolorem doloribus ducimus eos error ex molestiae nobis odio odit optio placeat quasi repudiandae, unde velit voluptate voluptatem!
									</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab commodi consectetur cupiditate ea, eius excepturi expedita illum, incidunt ipsam iste modi obcaecati optio repellendus! Dolore dolores pariatur sint veniam voluptates!</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci consequatur distinctio doloremque eos eum eveniet fuga molestiae mollitia nesciunt nisi nobis nostrum, odio omnis pariatur praesentium quibusdam sequi sint voluptates.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquam, aspernatur commodi consequuntur corporis dicta, distinctio enim eos expedita, id iste laborum maxime nesciunt quaerat sed temporibus veniam vero voluptatem.</p>
									<p><a href="http://gamejolt.com/games/slender-the-cursed-forest/30950">Link</a>
									</p>
									<hr>
									<time>Date</time>
								</li>
							</ul>
							<!--<div class="text-center p30"><i class="fa fa-list-alt" style="font-size: 100px;"></i> <br> No posts to show</div>-->
						
						</div>	
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>	
@endsection
