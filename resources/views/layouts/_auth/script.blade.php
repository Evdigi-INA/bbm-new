	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ asset('vendor/assets/plugins/jquery/jquery-1.9.1.min.js') }}"></script>
	<script src="{{ asset('vendor/assets/plugins/jquery/jquery-migrate-1.1.0.min.js') }}"></script>
	<script src="{{ asset('vendor/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('vendor/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('vendor/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset('vendor/assets/plugins/jquery-cookie/jquery.cookie.js') }}"></script>
	<!-- ================== END BASE JS ================== -->

	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="{{ asset('vendor/assets/js/login-v2.demo.min.js') }}"></script>
	<script src="{{ asset('vendor/assets/js/apps.min.js') }}"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
			LoginV2.init();
		});
	</script>
