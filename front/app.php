<?php

if (!empty($_GET['page']))
    $page = $_GET['page'];
else {
    $_GET['page'] = "projects";
    $page = 'projects';
}

$page = "pages/$page.php";

if (!is_readable($page)) {
    header('Location: 404.php');
    exit;
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Scrumup</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/logo_only.png" />

    <!-- STYLESHEETS -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Selector -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <!-- Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">


    <!-- JS SCRIPTS -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="js/adminlte.min.js"></script>
    <!-- Selector -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <!-- Datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <!-- Custom script -->
    <script defer src="js/utils.js"></script>
    <script>
        $(document).ready(function() {
            checkIsLoggedIn();
            displaySidebarProjects();
            $('#logout').click(function() {
                logout();
            })
        });
    </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a id="logout" class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                        <i class="fas fa-th-large"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="app.php" class="brand-link">
                <img src="img/logo_only.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Scrumup</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                        <li class="nav-header" id="header-selected-project"></li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link<?php if($_GET['page'] == "projects") {echo " active";}?>">
                                <i class="nav-icon fas fa-project-diagram"></i>
                                <p>
                                    Projets
                                    <span></span><i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" id="project-list-sidebar">
                                <li class="nav-item">
                                    <a href="app.php?page=projects" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Voir tous les projets</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="app.php?page=issues" class="nav-link<?php if($_GET['page'] == "issues") {echo " active";}?>">
                                <i class="nav-icon fas fa-th-list"></i>
                                <p>
                                    Issues
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="app.php?page=tasks" class="nav-link<?php if($_GET['page'] == "tasks") {echo " active";}?>">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>
                                    Tâches
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="app.php?page=sprints" class="nav-link<?php if($_GET['page'] == "sprints") {echo " active";}?>">
                                <i class="nav-icon fas fa-sync-alt"></i>
                                <p>
                                    Sprints
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="app.php?page=releases" class="nav-link<?php if($_GET['page'] == "releases") {echo " active";}?>">
                                <i class="nav-icon fas fa-box"></i>
                                <p>
                                    Releases
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="app.php?page=tests" class="nav-link<?php if($_GET['page'] == "tests") {echo " active";}?>">
                                <i class="nav-icon fas fa-flask"></i>
                                <p>
                                    Tests
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="app.php?page=docs" class="nav-link<?php if($_GET['page'] == "docs") {echo " active";}?>">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Documentation
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
            <?php include("$page"); ?>
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Projet Université de Bordeaux</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->
</body>
</html>
