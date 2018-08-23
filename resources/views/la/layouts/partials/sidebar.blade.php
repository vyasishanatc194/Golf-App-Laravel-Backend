
<nav id="sidebar" class="px-0 bg-dark bg-gradient sidebar">
	<ul class="nav nav-pills flex-column">
		<li class="logo-nav-item">
			@if(LAConfigs::getByKey('layout') != 'layout-top-nav')
			<!-- Logo -->
				<a href="{{ url(config('laraadmin.adminRoute')) }}" class="navbar-brand">
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><b>{{ LAConfigs::getByKey('sitename_part1') }}</b>
					{{ LAConfigs::getByKey('sitename_part2') }}</span>
				</a>
			@endif
		</li>
		<li>
			<h6 class="nav-header">General</h6>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="{{ url(config('laraadmin.adminRoute')) }}">
				<i class='fa fa-home'></i> 
				<span>Dashboard</span></a>
			</a>
		</li>
		<?php
            $menuItems = Dwij\Laraadmin\Models\Menu::where("parent", 0)->orderBy('hierarchy', 'asc')->get();
		?>	
        @foreach ($menuItems as $menu)
            @if($menu->type == "module")
                <?php
                    $temp_module_obj = Module::get($menu->name);
                ?>
				@la_access($temp_module_obj->id)
					<li class="nav-item ">	
						@if(isset($module->id) && $module->name == $menu->name)
							<a class="nav-link active" href="{{ url(config('laraadmin.adminRoute').'/'.$menu->url) }}">
						@else	
							<a class="nav-link" href="{{ url(config('laraadmin.adminRoute').'/'.$menu->url) }}">
						@endif	
							<i class=' fa {{$menu->icon}}'></i> 
								<span>{{$menu->name}} </span>
							</a>	
					</li>
                @endla_access
			@else
				<li class="nav-item">	
					<a class="nav-link nav-parent" href="#">
						<i class="fa {{$menu->icon}} "></i>
						{{$menu->name}} 
					</a>
					<ul class="nav nav-pills flex-column">
						<?php
							$childrens = \Dwij\Laraadmin\Models\Menu::where("parent", $menu->id)->orderBy('hierarchy', 'asc')->get();
						?>
						@foreach($childrens as $children)
							<li class="nav-item">	
								@if(isset($module->id) && $module->name == $children->name)
									<a class="nav-link active" href="{{ url(config('laraadmin.adminRoute').'/' .$children->url) }}">
								@else	
									<a class="nav-link" href="{{ url(config('laraadmin.adminRoute').'/' .$children->url) }}">
								@endif	
										<i class='fa {{$children->icon}}'></i> 
										<span>{{$children->name}} </span>
									</a>
							</li>
						@endforeach
					</ul>
				</li>
            @endif
        @endforeach
	</ul>
</nav>