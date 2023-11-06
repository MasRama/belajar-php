<?php 
  include_once("koneksi_crud.php");

  
class ProductManager {
    private $databaseConnection;

    public function __construct($databaseConnection) {
        $this->databaseConnection = $databaseConnection;
    }

    public function getProductsSearch($search, $offset) {
      $viewallsearch = $this->databaseConnection -> getConnection() -> query("CREATE OR REPLACE VIEW allproduksearch AS SELECT products.product_name, products.image, products.id, products.price, products.category_id, products.product_code, products.unit, products.description, products.stock, product_categories.category_name FROM products INNER JOIN product_categories ON products.category_id=product_categories.id WHERE products.product_name LIKE '%$search%' OR products.category_id LIKE '%$search%' OR products.description LIKE '%$search%' ORDER BY products.id ASC LIMIT 5 OFFSET $offset");

      if(!$viewallsearch) {
        echo "Error creating view";
      } else {
        $result =$this->databaseConnection -> getConnection() -> query("SELECT * FROM allproduksearch");
        $resultall = $this->databaseConnection -> getConnection() -> query("SELECT * FROM products WHERE product_name LIKE '%$search%' OR category_id LIKE '%$search%' OR description LIKE '%$search%'");
        $rowcount = mysqli_num_rows( $resultall );
        //return resuld and rowcount
        return array("result" => $result, "rowCount" => $rowcount);
      }
    }

    public function getProducts($offset) {
        $alldata = $this->databaseConnection -> getConnection() -> query("SELECT * FROM products;");
        $viewall = $this->databaseConnection -> getConnection() -> query("CREATE OR REPLACE VIEW allproduk AS SELECT products.product_name, products.image, products.price, products.id, products.category_id, products.product_code, products.unit, products.description, products.stock, product_categories.category_name FROM products INNER JOIN product_categories ON products.category_id=product_categories.id ORDER BY products.id ASC LIMIT 5 OFFSET $offset");
      if(!$viewall) {
        echo "Error creating view";
      } else {
        $result = $this->databaseConnection -> getConnection() -> query("SELECT * FROM allproduk");
        $rowcount = mysqli_num_rows( $alldata );
        return array("result" => $result, "rowCount" => $rowcount);
      }
    }

    public function formatToRupiah($angka) {
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
}

$id = $_GET['page'];

//check if page is empty
$page = (empty($_GET['page'])) ? 1 : $_GET['page'];
$offset = ($page - 1) * 5;

//format number to rupiah
function rupiah($angka){
  $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
  return $hasil_rupiah;
}

$productManager = new ProductManager($databaseConnection);

//search product
if(isset($_GET['search'])) {
  $results = $productManager->getProductsSearch($_GET['search'], $offset);
  $result = $results['result'];
  $rowcount = $results['rowCount'];

} else {
  $results = $productManager->getProducts($offset);
  $result = $results['result'];
  $rowcount = $results['rowCount'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fatqan Rama | AdminLTE</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../AdminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../AdminLTE/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../AdminLTE/dist//css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../AdminLTE/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../AdminLTE/plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../index.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">

          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>

        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../AdminLTE/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../AdminLTE/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../AdminLTE/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../AdminLTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Fatqan Ramadhiansyah</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Main Menu
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="dashboard.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Menu Index</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="newproduct.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Product
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">CRUD - Product Listing</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../index.html">Home</a></li>
              <li class="breadcrumb-item"><a href="./dashboard.html">Dashboard</a></li>
              <li class="breadcrumb-item active">Product Listing</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
           
           
            <!-- Main content -->
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header d-flex justify-content-end">                   
                      <h3 class="card-title col align-self-center">
                      <a href="./addproduct.php" class="btn btn-primary col-sm-2">
                        <i class="nav-icon fas fa-plus mr-2"></i> Tambah Produk
                      </a>
                      </h3>
                      <!-- <div class="col justify-content-md-end"> -->
                     

                  <form class="align-self-center" action="newproduct.php" method="GET">
        
                  <h5>Cari Produk</h5>
                  <div class="input-group input-group-sm" style="width: 150px;">

                    <input type="text" name="search" class="form-control float-right" placeholder="Cari produk">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>

                      
                    </div>
                  </div>
                  </form>
                      
                                   
                      <!-- </div> -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th style="width: 10px">No</th>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Harga</th>
                            <th>Unit</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Image</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>

                        <?php  
                        $index = $page * 5 - 4;
                          while($prod_data = mysqli_fetch_array($result)) {
                            //decode json
                            //echo var_dump($prod_data['image']);
                            $imagenow = json_decode($prod_data['image']);
                              echo "<tr>";
                              echo "<td> ". $index ." </td>";
                              echo "<td>".$prod_data['product_name']."</td>";
                              echo "<td>".$prod_data['product_code']."</td>";
                              echo "<td>".$prod_data['price']."</td>"; 
                              echo "<td>".$prod_data['unit']."</td>";   
                              echo "<td>".$prod_data['stock']."</td>";   
                              echo "<td>".$prod_data['category_name']."</td>"; 
                              echo "<td>".$prod_data['description']."</td>";
                              echo "<td>";
                              foreach($imagenow as $item) {
                                echo "<img src='$item' width='100px' height='100px'> <br>";
                              }
                              echo "</td>";
                              echo "<td> <a href='updateproduct.php?id=$prod_data[id]'> <button class='btn btn-info'> <i class='nav-icon fas fa-edit mr-2'></i>Edit</button> </a>  | <a href='delproduct.php?id=$prod_data[id]'> <button class='btn btn-danger'> <i class='nav-icon fas fa-trash-alt mr-2'></i>Delete</button>  </a> </td>"; 
                              // echo "<td><a href='edit.php?id=$user_data[id]'>Edit</a> | <a href='delete.php?id=$user_data[id]'>Delete</a></td>";
                              echo "</tr>";
                              $index++;        
                          }
                        ?>

                        </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                      <ul class="pagination pagination-sm m-0 float-right">
                        <?php
                            if(isset($_GET['search'])) {
                              $get = $_GET['search'];
                              //link back
                            if($page == 1) {
                              echo "<li class='page-item disabled'><a class='page-link' href='#'>&laquo;</a></li>";
                            } else {
                              echo "<li class='page-item'><a class='page-link' href='newproduct.php?search=$get&page=".($page - 1)."'>&laquo;</a></li>";
                            }
                            for($i = 1; $i <= ceil($rowcount / 5); $i++) {
                              //if page active
                              if($i == $page) {
                                echo "<li class='page-item'><a class='page-link' style='background-color: #007bff; color: white' href='newproduct.php?search=$get&page=$i'>$i</a></li>";
                              } else {
                                echo "<li class='page-item'><a class='page-link' href='newproduct.php?search=$get&page=$i'>$i</a></li>";
                              }
                            }
                            //link after
                            if($page == ceil($rowcount / 5)) {
                              echo "<li class='page-item disabled'><a class='page-link' href='#'>&raquo;</a></li>";
                            } else {
                              echo "<li class='page-item'><a class='page-link' href='newproduct.php?search=$get&page=".($page + 1)."'>&raquo;</a></li>";
                            }
                          } else {
                            //link back
                            if($page == 1) {
                              echo "<li class='page-item disabled'><a class='page-link' href='#'>&laquo;</a></li>";
                            } else {
                              echo "<li class='page-item'><a class='page-link' href='newproduct.php?page=".($page - 1)."'>&laquo;</a></li>";
                            }
                            for($i = 1; $i <= ceil($rowcount / 5); $i++) {
                              //if page active
                              if($i == $page) {
                                echo "<li class='page-item'><a class='page-link' style='background-color: #007bff; color: white' href='newproduct.php?page=$i'>$i</a></li>";
                              } else {
                                echo "<li class='page-item'><a class='page-link' href='newproduct.php?page=$i'>$i</a></li>";
                              }
                            }
                            //link after
                            if($page == ceil($rowcount / 5)) {
                              echo "<li class='page-item disabled'><a class='page-link' href='#'>&raquo;</a></li>";
                            } else {
                              echo "<li class='page-item'><a class='page-link' href='newproduct.php?page=".($page + 1)."'>&raquo;</a></li>";
                            }
                          }
                        ?>
                      </ul>
                    </div>
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
          </section>
              
           
          
         
          <section class="col-lg-5 connectedSortable">

            <!-- Main content -->
        
        
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
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
<script src="../AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../AdminLTE/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../AdminLTE/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../AdminLTE/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../AdminLTE/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../AdminLTE/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../AdminLTE/plugins/moment/moment.min.js"></script>
<script src="../AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../AdminLTE/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../AdminLTE/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../AdminLTE/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../AdminLTE/dist/js/pages/dashboard.js"></script>
</body>
</html>
