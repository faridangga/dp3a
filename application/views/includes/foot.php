<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/js/adminlte.min.js') ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/js/demo.js') ?>"></script>
<!-- Datatables -->
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?php echo base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
<!-- sweetalert -->
<script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert.min.js') ?>"></script>
<!-- Summernote -->
<script src="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.js') ?>"></script>
<!-- chartjs -->
<!-- <script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script> -->
<!-- pusher -->
<!-- <script src="<?php echo base_url('assets/plugins/pusher/pusher.min.js') ?>"></script> -->
<!-- dropify -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<!-- datepicker -->
<script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Custom JS-->
<script src="<?php echo base_url('assets/js/custom.js') ?>"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('71d114e69e897bd1d860', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      // alert(JSON.stringify(data)); 
      $(document).Toasts('create', {
        class: 'bg-warning',
        body: 'Data Pengaduan Masuk',
        title: 'PENGADUAN',
        position: 'topLeft',
        subtitle: 'Subtitle',
        icon: 'fas fa-envelope fa-lg',
      })
    });

  </script>
