<?php
session_start();
require_once("config/config.php");
if($_POST) {
  if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])){
    if(empty($_POST['name'])) {
      $nameError = "UserName Cannot be blank";
    }
    if(empty($_POST['email'])) {
      $emailError = "email Cannot be blank";
    }
    if(strlen($_POST['password'])<5) {
      $passwordError = "Password should be 5 characters at least";
    }
  } else {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'] , PASSWORD_DEFAULT);
    $statment = $pdo->prepare("SELECT * FROM `users` WHERE `email` = '$email'");
    $statment->execute();
    $user = $statment->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo "<script>alert('Email have been used, Try another email');</script>";
    } else {
        $statment = $pdo->prepare("INSERT INTO `users` (`name` , `password` , `email` , `role`) VALUES 
        (:name , :password , :email , 0)");
        $result = $statment->execute(
                    [
                        ':name'=>$name,
                        ':password'=>$password,
                        ':email'=>$email
                    ]
                );
        if ($result) {
            echo "<script>alert('Register Success, You can login now.');window.location.href='login.php';</script>";
        }
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blog | Register</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>BLog</b>User</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="register.php" method="post">
      <small class="text-danger d-block"><?php echo empty($nameError) ? '': '*'.$nameError; ?></small>
      <div class="input-group mb-3">
          <input type="text" class="form-control <?php echo empty($nameError) ? '' : 'is-invalid'; ?>" placeholder="Name" name="name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <small class="text-danger d-block"><?php echo empty($emailError) ? '': '*'.$emailError; ?></small>
        <div class="input-group mb-3">
          <input type="email" class="form-control <?php echo empty($emailError) ? '' : 'is-invalid'; ?>" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <small class="text-danger d-block"><?php echo empty($passwordError) ? '': '*'.$passwordError; ?></small>
        <div class="input-group mb-3">
          <input type="password" class="form-control <?php echo empty($passwordError) ? '' : 'is-invalid'; ?>" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="container">
                <button type="submit" class="btn btn-primary btn-block">Register</button>
                <a type="submit" href="login.php" class="btn btn-danger btn-block">Login</a>
            </div>
        </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
