
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
	<?php $this->load->view('includes/head'); ?>
</head>
<body class="hold-transition login-page p-t-10" style="background: #343a40;">
	<div class="login-box m-10">
		<div class="login-logo">
			<img src="<?php echo base_url('assets/img/logo.png') ?>" alt="" style="width: 75%; height: 75%;">
		</div>
		<br><br>
		<!-- /.login-logo -->
		<div class="card" style="border: 1px solid #c8ced3; border-radius: 0.25rem;">
			<div class="card-body login-card-body">
				<p class="login-box-msg">Sign in to start your session</p>

				<form action="#" method="post">
					<div class="input-group mb-3">
						<input type="email" class="form-control" placeholder="Email">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" placeholder="Password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<!-- /.col -->
						<div class="col-12">
							<button type="submit" class="btn btn-primary btn-block">Sign In</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- ./wrapper -->

	<!-- REQUIRED SCRIPTS -->
	<?php $this->load->view('includes/foot'); ?>
</body>
</html>
