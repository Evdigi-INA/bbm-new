 <!-- ================== BEGIN BASE JS ================== -->
 <script src="{{ asset('vendor/assets/plugins/jquery/jquery-1.9.1.min.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/jquery/jquery-migrate-1.1.0.min.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/jquery-cookie/jquery.cookie.js') }}"></script>
 <!-- ================== END BASE JS ================== -->

 <!-- ================== BEGIN PAGE LEVEL JS ================== -->
 {{-- <script src="{{ asset('vendor/assets/plugins/gritter/js/jquery.gritter.js') }}"></script> --}}
 <script src="{{ asset('vendor/assets/plugins/flot/jquery.flot.min.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/flot/jquery.flot.time.min.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/flot/jquery.flot.resize.min.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/flot/jquery.flot.pie.min.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/sparkline/jquery.sparkline.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/jquery-jvectormap/jquery-jvectormap.min.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
 <script src="{{ asset('vendor/assets/js/dashboard.min.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/DataTables/media/js/jquery.dataTables.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js') }}"></script>
 <script src="{{ asset('vendor/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js') }}">
 </script>
 <script src="{{ asset('vendor/assets/js/table-manage-default.demo.min.js') }}"></script>
 <script src="{{ asset('vendor/assets/js/apps.min.js') }}"></script>
 <!-- ================== END PAGE LEVEL JS ================== -->
 <script>
     $(document).ready(function() {
         App.init();
         Dashboard.init();
         TableManageDefault.init();
     });
 </script>

 @stack('custom-js')
