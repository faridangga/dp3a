<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/js/adminlte.min.js') ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/js/demo.js') ?>"></script>
<!-- Datatables -->
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/export/dataTables.buttons.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/export/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/export/jszip.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/export/pdfmake.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/export/vfs_fonts.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/export/buttons.html5.min.js') ?>"></script>

<!-- Select2 -->
<script src="<?php echo base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
<!-- sweetalert -->
<script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert.min.js') ?>"></script>
<!-- Summernote -->
<script src="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.js') ?>"></script>
<!-- chartjs -->
<!-- <script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script> -->
<!-- dropify -->
<script src="<?php echo base_url('assets/plugins/dropify/dropify.min.js') ?>"></script>
<!-- datepicker -->
<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.min.js') ?>"></script>
<!-- Custom JS-->
<script src="<?php echo base_url('assets/js/custom.js') ?>"></script>
<script>

  var notif = "<?php echo base_url('Admin/Notif/notif_pengaduan') ?>"
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('71d114e69e897bd1d860', {
      cluster: 'ap1',
      forceTLS: true
    });

    // function reloadPage(){
    //   location.reload(true);
    // }

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      // alert(JSON.stringify(data)); 
      $(document).Toasts('create', {
        class: 'bg-warning',
        body: 'Ada Data Pengaduan Masuk, silahkkan <a href="<?php echo base_url('Admin/Pengaduan') ?>"> dilihat </a>',
        title: 'PENGADUAN',
        position: 'topLeft',
        icon: 'fas fa-envelope fa-lg',
      })
      $.ajax({
        type: "GET",
        url: notif,
        dataType: 'json',
        success: function(data){
          $('#notif_pengaduan').html("");
          $('#notif_pengaduan').html(data);
          $('#badge_notif_pengaduan').html("");
          $('#badge_notif_pengaduan').html(data);
          // alert(data);
        }
      });
    });



  </script>
