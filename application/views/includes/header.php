<!-- Left navbar links -->
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
  </li>
</ul>


<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
  <!-- Notifications Dropdown Menu -->
  <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
      <i class="far fa-bell"></i>
      <span class="badge badge-warning navbar-badge"><?php echo $count_pengaduan ?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <span class="dropdown-header">Notifications</span>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">
        <i class="fas fa-envelope mr-2"></i> 
        <?php echo $count_pengaduan ?> New Pengaduan
      </a>
    </div>
  </li>
  <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
      <i class="fas fa-user"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <a href="#" class="dropdown-item">
        <!-- Message Start -->
        <div class="media">
          <img src="<?php echo base_url('assets/img/placeholder-user.png') ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
          <div class="media-body">
            <h3 class="dropdown-item-title">
              Farid
            </h3>
            <p class="text-sm"> <b>Admin</b></p>
          </div>
        </div>
        <!-- Message End -->
      </a>
      <div class="dropdown-divider"></div>
      <a href="<?php echo site_url('login/logout') ?>" class="dropdown-item dropdown-footer">Logout</a>
    </div>
  </li>
</ul>