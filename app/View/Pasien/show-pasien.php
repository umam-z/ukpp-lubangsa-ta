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
  <!-- iCheck -->
  <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
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
            <h1>Form Pasien</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-5">
            <div class="card card-primary">
              <div class="card-header">
                  <h3 class="card-title">Add Pasien</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="/pasien">
                  <div class="card-body">
                    <?php if (isset($model['error'])) { ?>
                      <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?= $model['error']; ?>
                      </div>
                    <?php } ?>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="exampleInputNama">Nama</label>
                          <input type="text" class="form-control" name="nama" id="exampleInputNama" placeholder="Enter...">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputNis">NIS</label>
                          <input name="nis" type="number" class="form-control" id="exampleInputNis" placeholder="Enter...">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputKabupaten">Kabupaten</label>
                          <input name="kabupaten" type="text" class="form-control" id="exampleInputKabupaten" placeholder="Enter...">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputKecamatan">Kecamatan</label>
                          <input name="kecamatan" type="text" class="form-control" id="exampleInputKecamatan" placeholder="Enter...">
                        </div>
                      </div>
                      <div class="col-sm-6">                       
                        <div class="form-group">
                          <label for="exampleInputDesa">Desa</label>
                          <input name="desa" type="text" class="form-control" id="exampleInputDesa" placeholder="Enter...">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputBlok">Blok</label>
                          <input name="blok" type="text" class="form-control" id="exampleInputBlok" placeholder="Enter...">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputNo">No</label>
                          <input name="no" type="number" class="form-control" id="exampleInputNo" placeholder="Enter...">
                        </div>
                        <div class="form-group">
                          <label>Pendidikan</label>
                          <select name="pendidikan" class="form-control">
                            <option value="" disabled selected>Choose option</option>
                            <?php foreach ($model['data']['pendidikan'] as $key => $value) { ?>
                              <option value="<?= $value->id; ?>"><?= $value->lembaga; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.col -->
        </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Pasien</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Daftar Pasien</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Kode</th>
                      <th>NIS</th>
                      <th>Nama</th>
                      <th>Kamar</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php  foreach ($model['data']['pasien'] as $key => $value) { ?>
                      <tr>
                        <td><?php  echo $value['pasien_id'] ?></td>
                        <td><?php  echo $value['nis'] ?></td>
                        <td><?php  echo $value['nama'] ?></td>
                        <td><?php  echo $value['blok'] ?> / <?php  echo $value['no'] ?></td>
                        <td><?php  echo $value['desa'] ?> <?php  echo $value['kecamatan'] ?> <?php  echo $value['kabupaten'] ?></td>
                        <td>
                        <div class="btn-group">
                          <div style="margin: 5px;">
                            <a  href="/pasien/<?php  echo $value['pasien_id']?>/periksa" class="btn btn-info btn-sm" >
                              <!-- icon altenatif -->
                              <!-- <i class="fas fa-file-medical-alt"></i> -->
                              <i class="fas fa-file-medical"></i>
                            </a>
                          </div>
                          <form action="/pasien/<?php  echo $value['pasien_id']?>/delete" method="post" style="margin: 5px">
                            <button class="btn btn-danger btn-sm" type="submit">
                              <i class="far fa-trash-alt"></i>
                            </button>
                          </form>
                        </div>
                        </td>
                    </tr>
                    <?php  } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
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

    // $('#example1').DataTable({
    //   "paging": true,
    //   "lengthChange": false,
    //   "searching": true,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false,
    //   "responsive": true,
    // });
  });
</script>
</body>
</html>
