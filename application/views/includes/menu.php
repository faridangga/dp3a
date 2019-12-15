<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="<?php echo base_url('Dashboard/index') ?>" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard
        </p>
      </a>
    </li>
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-circle"></i>
        <p>
          Master Data
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="<?php echo base_url('Admin/Admins') ?>" class="nav-link">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>
              Admin
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url('Admin/Users') ?>" class="nav-link">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>
              Users
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url('Admin/Golongan') ?>" class="nav-link">
            <i class="nav-icon fab fa-cloudsmith"></i>
            <p>
              Golongan
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url('Admin/Jabatan') ?>" class="nav-link">
            <i class="nav-icon fas fa-hat-cowboy-side"></i>
            <p>
              Jabatan
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url('Admin/Kategori_Laporan') ?>" class="nav-link">
            <i class="nav-icon fab fa-hotjar"></i>
            <p>
              Kategori Laporan
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url('Admin/Kategori_Post') ?>" class="nav-link">
            <i class="nav-icon fab fa-hotjar"></i>
            <p>
              Kategori Post
            </p>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a href="<?php echo base_url('Admin/Pengaduan') ?>" class="nav-link">
        <i class="nav-icon fas fa-hand-holding-heart"></i>
        <p>
          Pengaduan
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?php echo base_url('Admin/Posts') ?>" class="nav-link">
        <i class="nav-icon far fa-newspaper"></i>
        <p>
          Artikel
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?php echo base_url('Admin/Data_Kekerasan') ?>" class="nav-link">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>
          Data Kekerasan
        </p>
      </a>
    </li>
  </ul>
  <script>
    $('[href*="<?php echo $this->uri->segment(2) ?>"]').addClass('active');
  </script>
</nav>