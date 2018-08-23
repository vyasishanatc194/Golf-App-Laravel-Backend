<head>
    <meta charset="UTF-8">
    <title>@hasSection('htmlheader_title')@yield('htmlheader_title') - @endif{{ LAConfigs::getByKey('sitename') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
   
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700&amp;subset=latin-ext" rel="stylesheet">
    
    <!-- CSS - REQUIRED - START -->
	<!-- Batch Icons -->
	<link rel="stylesheet" href="{{ asset('adminTheme/fonts/batch-icons/css/batch-icons.css') }}">
	<!-- Bootstrap core CSS -->
	
	<link rel="stylesheet" href="{{ asset('adminTheme/css/bootstrap/bootstrap.min.css') }}">
	<!-- Material Design Bootstrap -->
	<link rel="stylesheet" href="{{ asset('adminTheme/css/bootstrap/mdb.min.css') }}">
	<!-- Custom Scrollbar -->
	<link rel="stylesheet" href="{{ asset('adminTheme/plugins/custom-scrollbar/jquery.mCustomScrollbar.min.css') }}">
	<!-- Hamburger Menu -->
	<link rel="stylesheet" href="{{ asset('adminTheme/css/hamburgers/hamburgers.css') }}">

	<!-- CSS - REQUIRED - END -->

	<!-- CSS - OPTIONAL - START -->
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('adminTheme/fonts/font-awesome/css/font-awesome.min.css') }}">
	
	<!-- JVMaps -->
	<link rel="stylesheet" href="{{ asset('adminTheme/plugins/jvmaps/jqvmap.min.css') }}">
	<!-- CSS - OPTIONAL - END -->
	<!-- Animate.css -->
	<link  rel="stylesheet" href="{{ asset('adminTheme/plugins/animate.css/animate.css') }}">
	<!-- Timelify -->
	<link  rel="stylesheet" href="{{ asset('adminTheme/plugins/timelify/css/timelify.css') }}">

	<!-- QuillPro Styles -->
	<link rel="stylesheet" href="{{ asset('adminTheme/css/quillpro/quillpro.css') }}">
	
	<link rel="stylesheet" href="{{ asset('adminTheme/plugins/datatables/css/responsive.dataTables.min.css') }}">
	<link rel="stylesheet" href="{{ asset('adminTheme/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
	
	<!-- AdminLTE App -->
	 <!-- Theme style -->
   
    

	@stack('styles')
    
</head>
