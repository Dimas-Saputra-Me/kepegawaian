<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="<?= base_url('AdminLTE/img/AdminLTELogo.png') ?>" alt="Company Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Kepegawaian</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <li class="nav-item">
                    <a href="<?= base_url('/') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('/pegawai') ?>" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Pegawai</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('/laporan') ?>" class="nav-link">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>Query/PHP</p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="/docs/3.0/components" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                        Additional
                        <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="#" class="nav-link ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Departemen</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Keahlian</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>
