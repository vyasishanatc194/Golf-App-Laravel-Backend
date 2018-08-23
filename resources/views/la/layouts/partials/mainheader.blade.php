
<nav class="navbar navbar-expand-lg navbar-light bg-white">
	@if(LAConfigs::getByKey('layout') != 'layout-top-nav')
		<!-- Logo -->
	<a href="{{ url(config('laraadmin.adminRoute')) }}" class="navbar-brand d-block d-sm-block d-md-block d-lg-none">
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>{{ LAConfigs::getByKey('sitename_part1') }}</b>
		{{ LAConfigs::getByKey('sitename_part2') }}</span>
	</a>
	@endif
	<button class="hamburger hamburger--slider" type="button" data-target=".sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle Sidebar">
		<span class="hamburger-box">
			<span class="hamburger-inner"></span>
		</span>
	</button>
	<!-- Added Mobile-Only Menu -->
	<ul class="navbar-nav ml-auto mobile-only-control d-block d-sm-block d-md-block d-lg-none">
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" id="navbar-notification-search-mobile" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
				<i class="batch-icon batch-icon-search"></i>
			</a>
			<ul class="dropdown-menu dropdown-menu-fullscreen" aria-labelledby="navbar-notification-search-mobile">
				<li>
					<form class="form-inline my-2 my-lg-0 no-waves-effect">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search for..." aria-label="Search for..." aria-describedby="basic-addon2">
							<div class="input-group-append">
								<button class="btn btn-primary btn-gradient waves-effect waves-light" type="button">
									<i class="batch-icon batch-icon-search"></i>
								</button>
							</div>
						</div>
					</form>
				</li>
			</ul>
		</li>
	</ul>
	<div class="collapse navbar-collapse" id="navbar-header-content">
		@include('la.layouts.partials.top_nav_menu')
		@include('la.layouts.partials.notifs')
	</div>
</nav>
