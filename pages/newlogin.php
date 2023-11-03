<?php 
include_once("koneksi_crud.php");

class Authentication {
  private $databaseConnection;

  public function __construct($databaseConnection) {
      $this->databaseConnection = $databaseConnection;
  }

  public function authenticateUser($username, $password) {
      $sql = "SELECT * FROM users WHERE username = '$username' AND password = MD5('$password')";
      $result = $this->databaseConnection->getConnection()->query($sql);

      if (mysqli_num_rows($result) == 1) {
          $row = $result->fetch_assoc();
          session_start();
          $_SESSION['username'] = $row['username'];
          $_SESSION['name'] = $row['name'];
          header('Location: dashboard.php');
      } else {
          echo 'User tidak ditemukan';
      }
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Inisialisasi autentikasi
  $authentication = new Authentication($databaseConnection);

  // Lakukan autentikasi
  $authentication->authenticateUser($username, $password);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fatqan Rama | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../AdminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../AdminLTE/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../AdminLTE/index2.html"><b>Fatqan</b> Rama</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Silahkan Masuk</p>

      <form action="newlogin.php" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
    
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      
      <!-- /.social-auth-links -->
      <p class="mb-0">
        <a href="register.php" class="text-center">Daftar akun disini</a>
      </p>
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>
