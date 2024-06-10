<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | General Form Elements</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
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
            <h1>General Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements disabled -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">General Elements</h3>
                    </div>
                <!-- /.card-header -->
                    <form>
                    <div class="card-body">
                        <form>
                        <div class="row">
                            <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Text</label>
                                <input type="text" class="form-control" placeholder="Enter ...">
                            </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-group">
                                <label>Text Disabled</label>
                                <input type="text" class="form-control" placeholder="Enter ..." disabled>
                            </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                    <!-- card header -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Sign in</button>
                        <!-- <button type="submit" class="btn btn-default float-right">Cancel</button> -->
                    </div>
                    </form>
                    <!-- card footer -->
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Striped Full Width Table</h3>
                    </div>
                <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                        <thead>
                            <tr>
                            <th style="width: 10px">#</th>
                            <th>Task</th>
                            <th>Progress</th>
                            <th style="width: 40px">Label</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>1.</td>
                            <td>Update software</td>
                            <td>
                                <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                </div>
                            </td>
                            <td><span class="badge bg-danger">55%</span></td>
                            </tr>
                            <tr>
                            <td>2.</td>
                            <td>Clean database</td>
                            <td>
                                <div class="progress progress-xs">
                                <div class="progress-bar bg-warning" style="width: 70%"></div>
                                </div>
                            </td>
                            <td><span class="badge bg-warning">70%</span></td>
                            </tr>
                            <tr>
                            <td>3.</td>
                            <td>Cron job running</td>
                            <td>
                                <div class="progress progress-xs progress-striped active">
                                <div class="progress-bar bg-primary" style="width: 30%"></div>
                                </div>
                            </td>
                            <td><span class="badge bg-primary">30%</span></td>
                            </tr>
                            <tr>
                            <td>4.</td>
                            <td>Fix and squish bugs</td>
                            <td>
                                <div class="progress progress-xs progress-striped active">
                                <div class="progress-bar bg-success" style="width: 90%"></div>
                                </div>
                            </td>
                            <td><span class="badge bg-success">90%</span></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                <!-- /.card-body -->
                </div>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
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
<!-- bs-custom-file-input -->
<script src="/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/assets/dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
