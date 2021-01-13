<?php
session_start();
require_once("config/config.php");
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header("location:login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Blogs | BLog</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="container-fluid">
  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-5">
          <div class="col-sm-12">
            <h1 class="text-center" style="font-size: 50px;">Browse Blog</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<?php
  $statement = $pdo->prepare("SELECT * FROM `post` ORDER BY `id` DESC");
  $statement->execute();
  $result = $statement->fetchAll();
?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
        <?php 
          if($result) {
            foreach($result as $posts){
        ?>
           <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                  <h3 class="text-center text-primary"><?php echo substr($posts['title'] , 0 , 40);?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="blogdetail.php?id=<?php echo $posts['id']; ?>">
                <img class="img-fluid pad mx-auto d-block" style="height: 300px; text-align: center;" src="Admin/images/<?php echo $posts['image']; ?>" alt="No photo found">
                </a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        <?php 
            }
          }
        ?>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!--scroll to top -->
    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
    <!-- /. scroll to top -->
  <footer>
    <div class="container-fluid text-secondary mb-5">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.0.5
      </div>
      <strong>Copyright &copy; 2014-2019 <a href="">yellyint48@gmail.com</a>.</strong> All rights
      reserved.
    </div>
  </footer>
  <!-- /.control-sidebar -->
</div>


<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
</body>
</html>
