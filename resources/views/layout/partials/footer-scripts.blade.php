<!-- all js files -->
<!--plugins-->



  <!-- Bootstrap bundle JS -->
  <script src="{{url('/').'/'}}assets/js/bootstrap.bundle.min.js"></script>
  <!--plugins-->
  <script src="{{url('/').'/'}}assets/js/jquery.min.js"></script>
  <script src="{{url('/').'/'}}assets/plugins/simplebar/js/simplebar.min.js"></script>
  <script src="{{url('/').'/'}}assets/plugins/metismenu/js/metisMenu.min.js"></script>
  <script src="{{url('/').'/'}}assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
  <script src="{{url('/').'/'}}assets/js/pace.min.js"></script>
  {{-- <script src="{{url('/').'/'}}assets/plugins/chartjs/js/Chart.min.js"></script>
  <script src="{{url('/').'/'}}assets/plugins/chartjs/js/Chart.extension.js"></script>
  <script src="{{url('/').'/'}}assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script> --}}
   <!-- Vector map JavaScript -->
   <script src="{{url('/').'/'}}assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
   <script src="{{url('/').'/'}}assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>

  <!--notification js -->
  <script src="{{url('/').'/'}}assets/plugins/notifications/js/lobibox.min.js"></script>
  <script src="{{url('/').'/'}}assets/plugins/notifications/js/notifications.min.js"></script>
  <script src="{{url('/').'/'}}assets/plugins/notifications/js/notification-custom-script.js"></script>
 <script src="{{url('/').'/'}}assets/js/pace.min.js"></script>

   <!--app-->

  {{-- <script src="{{url('/').'/'}}assets/js/index.js"></script> --}}

  <script src="{{url('/').'/'}}assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
  <script src="{{url('/').'/'}}assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="{{url('/').'/'}}assets/js/table-datatable.js"></script>
  <script src="{{url('/').'/'}}assets/js/app.js"></script>
  <script>
    new PerfectScrollbar(".review-list")
    new PerfectScrollbar(".chat-talk")
 </script>
<script>
    $(document).ready(function() {
        // Initialize DataTables for each table
        $('#users_table').DataTable({
            "order": [[ 3, "desc" ]], // Example ordering for table1, replace with your desired ordering
            "columnDefs": [
                { "data": "data-name", "orderable": 0 } // Sort by data-id attribute for the first column
            ]
        });

        $('#loans_table').DataTable({
            "order": [[ 2, "desc" ]] // Example ordering for table2, replace with your desired ordering
        });
        $('#emis_table').DataTable({
            "order": [[ 3, "asc" ]] // Example ordering for table2, replace with your desired ordering
        });

        // Add more tables as needed
    });
    </script>

