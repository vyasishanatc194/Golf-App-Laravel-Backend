<!-- Content Header (Page header) -->
<div class="row">
	<div class="col-md-12">
        <h1>
            @yield('contentheader_title', 'Page Header here')
            <small>@yield('contentheader_description')</small>
        </h1>
        @hasSection('headerElems')
            <span class="headerElems">
            @yield('headerElems')
            </span>
        @else 
            @hasSection('section')
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="@yield('section_url')"><i class="fa fa-dashboard"></i> @yield('section')</a></li>
                    @hasSection('sub_section')<li class="active"> @yield('sub_section') </li>@endif
                </ol>
			</nav>
            @endif
        @endif
    </div>
</div>