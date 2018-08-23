<ul class="navbar-nav navbar-notifications float-right">
	@if(LAConfigs::getByKey('show_messages'))
		<!-- <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle no-waves-effect" id="navbar-notification-calendar" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
				<i class="batch-icon batch-icon-calendar"></i>
				<span class="notification-number">6</span>
			</a>
			<ul class="dropdown-menu dropdown-menu-right dropdown-menu-md" aria-labelledby="navbar-notification-calendar">
				<li class="media">
					<a href="task-list.html">
						<i class="batch-icon batch-icon-calendar batch-icon-xl d-flex mr-3"></i>
						<div class="media-body">
							<h6 class="mt-0 mb-1 notification-heading">Meeting with Project Manager</h6>
							<div class="notification-text">
								Cras sit amet nibh libero
							</div>
							<span class="notification-time">Right now</span>
						</div>
					</a>
				</li>
				<li class="media">
					<a href="task-list.html">
						<i class="batch-icon batch-icon-calendar batch-icon-xl d-flex mr-3"></i>
						<div class="media-body">
							<h6 class="mt-0 mb-1 notification-heading">Sales Call</h6>
							<div class="notification-text">
								Nibh amet cras sit libero
							</div>
							<span class="notification-time">One hour from now</span>
						</div>
					</a>
				</li>
				<li class="media">
					<a href="task-list.html">
						<i class="batch-icon batch-icon-calendar batch-icon-xl d-flex mr-3"></i>
						<div class="media-body">
							<h6 class="mt-0 mb-1 notification-heading">Email CEO new expansion proposal</h6>
							<div class="notification-text">
								Cras sit amet nibh libero
							</div>
							<span class="notification-time">In 3 days</span>
						</div>
					</a>
				</li>
				<li class="media">
					<a href="task-list.html">
						<i class="batch-icon batch-icon-calendar batch-icon-xl d-flex mr-3"></i>
						<div class="media-body">
							<h6 class="mt-0 mb-1 notification-heading">Team building exercise</h6>
							<div class="notification-text">
								Cras sit amet nibh libero
							</div>
							<span class="notification-time">In one week</span>
						</div>
					</a>
				</li>
			</ul>
		</li> -->
	@endif
	@if(LAConfigs::getByKey('show_notifications'))
		<!-- <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle no-waves-effect" id="navbar-notification-misc" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
				<i class="batch-icon batch-icon-bell"></i>
				<span class="notification-number">4</span>
			</a>
			<ul class="dropdown-menu dropdown-menu-right dropdown-menu-md" aria-labelledby="navbar-notification-misc">
				<li class="media">
					<a href="task-list.html">
						<i class="batch-icon batch-icon-bell batch-icon-xl d-flex mr-3"></i>
						<div class="media-body">
							<h6 class="mt-0 mb-1 notification-heading">General Notification</h6>
							<div class="notification-text">
									Cras sit amet nibh libero
							</div>
							<span class="notification-time">Just now</span>
						</div>
					</a>
				</li>
				<li class="media">
					<a href="task-list.html">
						<i class="batch-icon batch-icon-cloud-download batch-icon-xl d-flex mr-3"></i>
						<div class="media-body">
							<h6 class="mt-0 mb-1 notification-heading">Your Download Is Ready</h6>
							<div class="notification-text">
								Nibh amet cras sit libero
							</div>
							<span class="notification-time">5 minutes ago</span>
						</div>
					</a>
				</li>
				<li class="media">
					<a href="task-list.html">
						<i class="batch-icon batch-icon-tag-alt-2 batch-icon-xl d-flex mr-3"></i>
						<div class="media-body">
							<h6 class="mt-0 mb-1 notification-heading">New Order</h6>
							<div class="notification-text">
								Cras sit amet nibh libero
							</div>
							<span class="notification-time">Yesterday</span>
						</div>
					</a>
				</li>
				<li class="media">
					<a href="task-list.html">
						<i class="batch-icon batch-icon-pull batch-icon-xl d-flex mr-3"></i>
						<div class="media-body">
							<h6 class="mt-0 mb-1 notification-heading">Pull Request</h6>
							<div class="notification-text">
								Cras sit amet nibh libero
							</div>
							<span class="notification-time">3 day ago</span>
						</div>
					</a>
				</li>
			</ul>
		</li> -->
	@endif
</ul>	
@if (Auth::guest())
	<li><a href="{{ url('/login') }}">Login</a></li>
	<li><a href="{{ url('/register') }}">Register</a></li>
@else	
	<ul class="navbar-nav ml-5 navbar-profile">
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" id="navbar-dropdown-navbar-profile" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
				<div class="profile-picture bg-gradient bg-primary has-message float-left">
					<img src="{{ Gravatar::fallback(asset('la-assets/img/user2-160x160.jpg'))->get(Auth::user()->email) }}" width="44" height="44" class="user-image" alt="User Image"/>
				</div>
			</a>
			<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-dropdown-navbar-profile">
				<li > 
					<div class="profile-picture bg-gradient bg-primary mx-auto">
						<img src="{{ Gravatar::fallback(asset('la-assets/img/user2-160x160.jpg'))->get(Auth::user()->email) }}" width="44" height="44" class="user-image" alt="User Image"/>
					</div>
					<p class="text-center">
						{{ Auth::user()->name }}
						<?php $datec = Auth::user()['created_at']; ?>
						<small>Member since <?php echo date("M. Y", strtotime($datec)); ?></small>
					</p>
				</li>
				@role("SUPER_ADMIN")
					<li >
						<a class="dropdown-item" href="{{ url(config('laraadmin.adminRoute') . '/lacodeeditor') }}">
							<i class="fa fa-code"></i> <span>Editor</span>
						</a>
					</li>
					<li>
						<a class="dropdown-item" href="{{ url(config('laraadmin.adminRoute') . '/modules') }}">
							<i class="fa fa-cubes"></i> <span>Modules</span>
						</a>
					</li>
					<li>
						<a class="dropdown-item" href="{{ url(config('laraadmin.adminRoute') . '/la_menus') }}">
							<i class="fa fa-bars"></i> <span>Menus</span>
						</a>
					</li>
					<li>
						<a class="dropdown-item" href="{{ url(config('laraadmin.adminRoute') . '/la_configs') }}">
							<i class="fa fa-cogs"></i><span>Configure</span>
						</a>
					</li>
					<li>
						<a class="dropdown-item" href="{{ url(config('laraadmin.adminRoute') . '/backups') }}">
							<i class="fa fa-hdd-o"></i> <span>Backups</span>
						</a>
					</li>
				
				@endrole
								<!-- Menu Footer-->
				<li class="pull-left">
					<a href="{{ url(config('laraadmin.adminRoute') . '/users/') .'/'. Auth::user()->id }}" class="dropdown-item notification-heading">Profile</a>
				</li>
				<li class="pull-right">
					<a href="{{ url('/logout') }}" class="dropdown-item">Sign out</a>
				</li>
			</ul>
		</li>
	</ul>
@endif	