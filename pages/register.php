<?php 
include_once("koneksi_crud.php");


class RegisterUser {
  private $databaseConnection;

  public function __construct($databaseConnection) {
      $this->databaseConnection = $databaseConnection;
  }

  public function registerUser($nama, $email, $nohp, $password, $passwordretry) {
      if ($password == $passwordretry) {
          $sql = "SELECT * FROM users WHERE username = '$nohp'";
          $result = $this->databaseConnection->getConnection()->query($sql);

          if (mysqli_num_rows($result) == 0) {
              $sql = "INSERT INTO users (name, email, phone_number, password, username, group_id) VALUES ('$nama', '$email', '$nohp', MD5('$password'), '$nohp', 3)";

              $result = $this->databaseConnection->getConnection()->query($sql);

              if ($result) {
                  header('Location: newlogin.php');
              } else {
                  echo 'Registrasi gagal';
              }
          } else {
              echo 'Email sudah terdaftar';
          }
      } else {
          echo 'Password tidak sama';
      }
  }
}

$regist = new RegisterUser($databaseConnection);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $nohp = $_POST['nohp'];
  $password = $_POST['password'];
  $passwordretry = $_POST['passwordretry'];

  $regist->registerUser($nama, $email, $nohp, $password, $passwordretry);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fatqan Rama | Register</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../AdminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../AdminLTE/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="../AdminLTE/index2.html"><b>Fatqan</b> Rama</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Daftar User</p>

      <form action="register.php" method="post">
        <div class="input-group mb-3">
          <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="number" name="nohp" class="form-control" placeholder="08xxx">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
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
        <div class="input-group mb-3">
          <input type="password" name="passwordretry" class="form-control" placeholder="Masukkan password ulang">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center">
        
      </div>

      <a href="newlogin.php" class="text-center">Login disini</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>
