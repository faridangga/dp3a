<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<?php $this->load->view('includes/head'); ?>

<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">

		<?php $this->load->view('includes/header'); ?>


		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
				<?php $this->load->view('includes/breadcrumb'); ?>
			<!-- Main content -->
			<section class="content container-fluid">

           
                <div class="error404">
                    <img src="<?php echo base_url();?>/assets/images/error404.jpg" alt="" width="20%">
                    <h2>Oops Sorry</h2>
                    <p>we could not find the page</p>
                    <a class="btn btn-primary btn-custom" href="<?php echo lang_base_url(); ?>"><?php echo trans("btn_goto_home"); ?></a>
                </div>


			    </section>
			    <!-- /.content -->
			</div>
			<!-- /.content-wrapper -->

			<!-- Main Footer -->
			<footer class="main-footer">
				<!-- To the right -->
				<div class="pull-right hidden-xs">
					Anything you want
				</div>
				<!-- Default to the left -->
				<strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
			</footer>

<!-- Add the sidebar's background. This div must be placed
	immediately after the control sidebar -->
	
</div>
<!-- ./wrapper -->
<?php $this->load->view('includes/foot'); ?>
</body>
</html>