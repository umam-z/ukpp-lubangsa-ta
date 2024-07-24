<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $model['title'] ?? 'UKPP Lubangsa'; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">UKPP Lubangsa</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/assets/dist/img/user2-160x160.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $model['user']['nama'] ?? 'Administrator'; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/petugas" class="nav-link">
              <i class="nav-icon fas fa-user-md"></i>
              <p>
                Petugas
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/pasien" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Pasien
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/obat" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>
              Obat
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/laporan" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Laporan
              </p>
            </a>
          </li>
          <li class="nav-header">ADMINISTRASI</li>
          <li class="nav-item">
            <a href="/pendidikan" class="nav-link">
              <i class="nav-icon fas fa-school"></i>
              <p>
                Pendidikan
              </p>
            </a>
          </li>
          <li class="nav-header">SESSION</li>
          <li class="nav-item">
            <a href="/users/logout" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Sign Out
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pemeriksaan Kode : <?= $model['data']['pemeriksaan']->getId() ?></h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">

          </div>
          <div class="col-md-4">
             <!-- general form elements -->
             <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Info</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div>
                <div class="card-body">
                  <?php if (isset($model['error'])) { ?>
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <?= $model['error']; ?>
                    </div>
                  <?php } ?>
                  <div class="form-group">
                    <label for="inputKeluhan">Keluhan</label>
                    <input type="text" class="form-control" value="<?= $model['data']['pemeriksaan']->getKeluhan() ?>" id="inputKeluhan" disabled>
                  </div>
                  <div class="form-group">
                    <label for="inputDiagnosa">Diagnosa</label>
                    <input type="text" class="form-control" value="<?= $model['data']['pemeriksaan']->getDiagnos() ?>" id="inputDiagnosa" disabled>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <?php if (!empty($model['data']['obatperiksa'])) { ?>
                    <form action="/pasien/<?= $model['data']['pemeriksaan']->getPasienId() ?>/surat" method="post" style="margin: 5px;">
                      <button type="submit" class="btn btn-block btn-primary"><i class="far fa-envelope"></i> Surat</button>
                    </form>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Pengobatan</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Pengobatan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Obat</th>
                      <th>Jumlah</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php  foreach ($model['data']['obatperiksa'] ?? [] as $key => $value) { ?>
                      <tr>
                        <td><?php echo $value['obat']; ?></td>
                        <td><?php echo $value['qty']; ?></td>
                        <td>
                          <div class="btn-group">
                              <form action="/periksa/<?php echo $value['pemeriksaan_id']; ?>/obat/<?php echo $value['obat_id']; ?>/delete" method="post" style="margin: 5px;">
                                <button type="submit" class="btn btn-danger btn-sm">
                                  <i class="far fa-trash-alt"></i>
                                </button>
                              </form>
                            </div>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Obat</h3>
          </div>
        </div>
        <div class="row">
          <?php foreach ($model['data']['obat'] ?? [] as $key => $value) { ?>
            <div class="col-md-3">
          <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <h3 class="profile-username text-center"><?= $value->getObat(); ?></h3>

                <p class="text-muted text-center">Keterangan</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Kode</b> <a class="float-right"><?= $value->getId(); ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Stock</b> <a class="float-right"><?= $value->getStock(); ?></a>
                  </li>
                </ul>
                <form action="/periksa/<?= $model['data']['pemeriksaan']->getId() ?>/obat/<?= $value->getId(); ?>/pasien" method="post">
                  <div class="form-group">
                    <label for="inputJumlah">Jumlah</label>
                    <input name="qty" type="number" class="form-control"  id="inputJumlah">
                  </div>
                  <button class="btn btn-success btn-block" type="submit">Submit</button>
                </form>
                <!-- <a href="#" class="btn btn-danger btn-block"><b>Hapus</b></a> -->
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <?php } ?>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020-2024 <a href="http://ukpp-lubangsa.net/">ukpp-lubangsa.net</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/assets/plugins/jszip/jszip.min.js"></script>
<script src="/assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/dist/js/adminlte.min.js"></script>
<script>
  $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
