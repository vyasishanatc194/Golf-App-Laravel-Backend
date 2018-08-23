<ul class="navbar-nav navbar-language-translation mr-auto">
	<!-- <li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" id="navbar-dropdown-menu-link" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
			<i class="batch-icon batch-icon-book-alt-"></i>
			English
		</a>
		<ul class="dropdown-menu" aria-labelledby="navbar-dropdown-menu-link">
			<li><a class="dropdown-item" href="#">Français</a></li>
			<li><a class="dropdown-item" href="#">Deutsche</a></li>
			<li><a class="dropdown-item" href="#">Español</a></li>
		</ul>
	</li> -->
</ul>
@if(LAConfigs::getByKey('sidebar_search'))
<ul class="navbar-nav navbar-notifications float-right">
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" id="navbar-notification-search" data-toggle="dropdown" data-flip="false" aria-haspopup="true" aria-expanded="false">
			<i class="batch-icon batch-icon-search"></i>
		</a>
		<ul class="dropdown-menu dropdown-menu-fullscreen" aria-labelledby="navbar-notification-search">
			<li>
				<form class="form-inline my-2 my-lg-0 no-waves-effect">
					<div class="input-group">
						<input type="text" id="navbar-search-input" class="form-control" placeholder="Search for..." aria-label="Search for..." aria-describedby="basic-addon2">
						<div class="input-group-append">
							<button class="btn btn-primary btn-gradient waves-effect waves-light" type="button">Search</button>
						</div>
					</div>
				</form>
			</li>
		</ul>
	</li>						
</ul>
@endif 
