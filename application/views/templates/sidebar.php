<style>
    .nav-treeview .nav-link {
        margin-left: 1rem;
    }
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <!-- Header -->
                <nav class=" justify-content-end align-items-center">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user-circle fa-lg"></i> <?= $this->session->userdata('username') ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?= base_url('master/user') ?>"><i class="fas fa-user"></i> Profile</a>
                                    <a class="dropdown-item" href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="<?= base_url('assets/template/') ?>dist/img/apotek.JPEG" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">
                    <h4><b>Pruwatan Sehat</b></h4>
                </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="<?php echo base_url('dashboard') ?>" class="nav-link" data-page="dashboard">
                                <i class="nav-icon fas fa-landmark"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        
                        <?php if ((strtolower($this->session->userdata('role')) == "admin") || (strtolower($this->session->userdata('role')) == "kasir")) :?>
                        <?php if ((strtolower($this->session->userdata('role')) == "admin")) :?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Master</p>
                                <i class="right fas fa-angle-left"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo base_url('master/satuan') ?>" class="nav-link gulung" data-page="satuan">
                                        <i class="nav-icon fa-solid fas fa-filter"></i>
                                        <p>Data Satuan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo base_url('master/kategori') ?>" class="nav-link gulung" data-page="kategori">
                                        <i class="nav-icon fa-solid fas fa-flask"></i>
                                        <p>Data Kategori</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo base_url('master/supplier') ?>" class="nav-link gulung" data-page="supplier">
                                        <i class="nav-icon fa-solid fas fa-store"></i>
                                        <p>Data Supplier</p>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="<?php echo base_url('master/pasien') ?>" class="nav-link">
                                        <i class="nav-icon fa-solid fas fa-user-plus"></i>
                                        <p>Data Pasien</p>
                                    </a>
                                </li> -->
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('master/obat') ?>" class="nav-link" data-page="obat">
                                <i class="nav-icon fas fa-pills"></i>
                                <p>Data Obat</p>
                            </a>
                        </li>
                        <?php endif ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>Transaksi</p>
                                <i class="right fas fa-angle-left"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo base_url('master/pembelian') ?>" class="nav-link gulung" data-page="pembelian">
                                        <i class="nav-icon fas fa-solid fa-download"></i>
                                        <p>Pembelian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo base_url('master/penjualan') ?>" class="nav-link gulung" data-page="penjualan">
                                        <i class="nav-icon fas fa-solid fa-upload"></i>
                                        <p>Penjualan</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <?php endif ?>
                        <?php if ((strtolower($this->session->userdata('role')) == "admin") || (strtolower($this->session->userdata('role')) == "owner"))  :?>
                        <li class="nav-item">
                            <a href="<?php echo base_url('master/laporan') ?>" class="nav-link" data-page="laporan">
                                <i class="nav-icon fas fa-solid fa-chart-line"></i>
                                <p>Laporan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('master/user') ?>" class="nav-link" data-page="user">
                                <i class="nav-icon fas fa-users"></i>
                                <p>User Management</p>
                            </a>
                        </li>
                        <?php endif ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <!-- <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Starter Page</h1>
                        </div> /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">