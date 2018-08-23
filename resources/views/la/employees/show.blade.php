@extends('la.layouts.app')

@section('htmlheader_title')
	Employee View
@endsection


@section('main-content')
<div id="page-content">
	<div class="row mb-5">
		<div class="col-md-12">
			<div class="card bg-primary bg-gradient">
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-3">
									<img class="profile-image" src="{{ Gravatar::fallback(asset('/img/avatar5.png'))->get(Auth::user()->email, ['size'=>400]) }}" alt="">
								</div>
								<div class="col-md-9">
									<h4 class="name">{{ $employee->$view_col }}</h4>
									<div class="row stats">
										<div class="col-md-6 stat"><div class="label2" data-toggle="tooltip" data-placement="top" title="Designation">{{ $employee->designation }}</div></div>
										<div class="col-md-6 stat"><i class="fa fa-map-marker"></i> {{ $employee->city or "NA" }}</div>
									</div>
									<p class="desc">{{ substr($employee->about, 0, 33) }}@if(strlen($employee->about) > 33)...@endif</p>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="dats1"><i class="fa fa-envelope-o"></i> {{ $employee->email }}</div>
							<div class="dats1"><i class="fa fa-phone"></i> {{ $employee->mobile }}</div>
							<div class="dats1"><i class="fa fa-clock-o"></i> Joined on {{ date("M d, Y", strtotime($employee->date_hire)) }}</div>
						</div>
						<div class="col-md-4">
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
							
						</div>
						<div class="col-md-1 actions">
							@la_access("Employees", "edit")
								<a href="{{ url(config('laraadmin.adminRoute') . '/employees/'.$employee->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
							@endla_access
							
							@la_access("Employees", "delete")
								{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.employees.destroy', $employee->id], 'method' => 'delete', 'style'=>'display:inline']) }}
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
						<li class="nav-item"><a class="nav-link" href="{{ url(config('laraadmin.adminRoute') . '/employees') }}" data-toggle="tooltip" data-placement="right" title="Back to Employees"><i class="fa fa-chevron-left"></i></a></li>
						<li class="nav-item"><a class="nav-link active show" role="tab" data-toggle="tab"  href="#tab-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
						<li class="nav-item"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-timeline" data-target="#tab-timeline"><i class="fa fa-clock-o"></i> Timeline</a></li>
						@if($employee->id == Auth::user()->id || Entrust::hasRole("SUPER_ADMIN"))
							<li class="nav-item"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-account-settings" data-target="#tab-account-settings"><i class="fa fa-key"></i> Account settings</a></li>
						@endif
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
										@la_display($module, 'designation')
										@la_display($module, 'gender')
										@la_display($module, 'mobile')
										@la_display($module, 'mobile2')
										@la_display($module, 'email')
										@la_display($module, 'dept')
										@la_display($module, 'city')
										@la_display($module, 'address')
										@la_display($module, 'about')
										@la_display($module, 'date_birth')
										@la_display($module, 'date_hire')
										@la_display($module, 'date_left')
										@la_display($module, 'salary_cur')
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
						
						@if($employee->id == Auth::user()->id || Entrust::hasRole("SUPER_ADMIN"))
						<div role="tabpanel" class="tab-pane fade" id="tab-account-settings">
							<div class="tab-content">
								<form action="{{ url(config('laraadmin.adminRoute') . '/change_password/'.$employee->id) }}" id="password-reset-form" class="general-form dashed-row white" method="post" accept-charset="utf-8">
									{{ csrf_field() }}
									<div class="panel">
										<div class="panel-default panel-heading">
											<h4>Account settings</h4>
										</div>
										<div class="panel-body">
											@if (count($errors) > 0)
												<div class="alert alert-danger">
													<ul>
														@foreach ($errors->all() as $error)
															<li>{{ $error }}</li>
														@endforeach
													</ul>
												</div>
											@endif
											@if(Session::has('success_message'))
												<p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success_message') }}</p>
											@endif
											<div class="form-group">
												<label for="password" class=" col-md-2">Password</label>
												<div class=" col-md-10">
													<input type="password" name="password" value="" id="password" class="form-control" placeholder="Password" autocomplete="off" required="required" data-rule-minlength="6" data-msg-minlength="Please enter at least 6 characters.">
												</div>
											</div>
											<div class="form-group">
												<label for="password_confirmation" class=" col-md-2">Retype password</label>
												<div class=" col-md-10">
													<input type="password" name="password_confirmation" value="" id="password_confirmation" class="form-control" placeholder="Retype password" autocomplete="off" required="required" data-rule-equalto="#password" data-msg-equalto="Please enter the same value again.">
												</div>
											</div>
										</div>
										<div class="panel-footer">
											<button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> Change Password</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>		
@endsection

@push('scripts')
<script>
$(function () {
	@if($employee->id == Auth::user()->id || Entrust::hasRole("SUPER_ADMIN"))
	$('#password-reset-form').validate({
		
	});
	@endif
});
</script>
@endpush
