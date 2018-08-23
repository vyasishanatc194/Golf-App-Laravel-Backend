<!-- SCRIPTS - REQUIRED START -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- Bootstrap core JavaScript -->
	<!-- JQuery -->
	<script type="text/javascript" src="{{ asset('adminTheme/js/jquery/jquery-3.1.1.min.js') }}"></script>
	<!-- Popper.js - Bootstrap tooltips -->
	<script type="text/javascript" src="{{ asset('adminTheme/js/bootstrap/popper.min.js') }}"></script>
	<!-- Bootstrap core JavaScript -->
	<script type="text/javascript" src="{{ asset('adminTheme/js/bootstrap/bootstrap.min.js') }}"></script>
	<!-- MDB core JavaScript -->
	<script type="text/javascript" src="{{ asset('adminTheme/js/bootstrap/mdb.min.js') }}"></script>
	<!-- Velocity -->
	<script type="text/javascript" src="{{ asset('adminTheme/plugins/velocity/velocity.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('adminTheme/plugins/velocity/velocity.ui.min.js') }}"></script>
	<!-- Custom Scrollbar -->
	<script type="text/javascript" src="{{ asset('adminTheme/plugins/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
	<!-- jQuery Visible -->
	<script type="text/javascript" src="{{ asset('adminTheme/plugins/jquery_visible/jquery.visible.min.js') }}"></script>
	
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script type="text/javascript" src="{{ asset('adminTheme/js/misc/ie10-viewport-bug-workaround.js') }}"></script>

	<!-- SCRIPTS - REQUIRED END -->

	<!-- SCRIPTS - OPTIONAL START -->
	<!-- ChartJS -->
	<script type="text/javascript" src="{{ asset('adminTheme/plugins/chartjs/chart.bundle.min.js') }}"></script>
	<!-- JVMaps -->
	<script type="text/javascript" src="{{ asset('adminTheme/plugins/jvmaps/jquery.vmap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('adminTheme/plugins/jvmaps/maps/jquery.vmap.usa.js') }}"></script>
	<!-- Image Placeholder -->
	<script type="text/javascript" src="{{ asset('adminTheme/js/misc/holder.min.js') }}"></script>
	<!-- SCRIPTS - OPTIONAL END -->

	<!-- QuillPro Scripts -->
	<script type="text/javascript" src="{{ asset('adminTheme/js/scripts.js') }}"></script>
		<!-- Timelify -->
	<script type="text/javascript" src="{{ asset('adminTheme/plugins/timelify/js/jquery.timelify.min.js') }}"></script>
	<!-- SCRIPTS - OPTIONAL END -->

	<script type="text/javascript" src="{{ asset('adminTheme/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('adminTheme/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('adminTheme/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>


<!-- AdminLTE App -->
<script src="{{ asset('la-assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
@stack('scripts')