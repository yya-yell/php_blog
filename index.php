<?php
session_start();
require_once("config/config.php");
require_once("config/common.php");

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header("location:login.php");
}
if(empty($_GET['pageno'])) {
  $pageno = 1;
} else {
  $pageno = $_GET['pageno'];
}
$numOfrec = 6;
$offset = ($pageno - 1 ) * $numOfrec;
$rec = $pdo->prepare("SELECT * FROM post");
$rec->execute();
$totrec = $rec->fetchAll();
$totalpage = ceil(count($totrec)/$numOfrec);
$stat = $pdo->prepare("SELECT * FROM post LIMIT $offset , $numOfrec");
$stat->execute();
$result = $stat->fetchAll();

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
                  <h3 class="text-center text-primary"><?php echo escape(substr($posts['title'] , 0 , 40));?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="blogdetail.php?id=<?php echo $posts['id']; ?>&&pageno=<?php echo $pageno; ?>">
                <img class="img-fluid pad mx-auto d-block" style="height: 300px; text-align: center;" src="Admin/images/<?php echo escape($posts['image']); ?>" 
                alt="No photo found">
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
    <!-- pagination -->
    <div class="container">
          <ul class="pagination justify-content-center">
            <li class="page-item"><a href="?pageno=1" class="page-link">First</a></li>
            <li class="page-item <?php if($pageno <= 1){echo "disabled";} ?>">
              <a href="<?php if($pageno <= 1){echo "disabled";}else{echo "?pageno=".($pageno-1);}?>" class="page-link">Previous</a>
            </li>
            <li class="page-item"><a href="" class="page-link"><?php echo escape($pageno);?></a></li>
            <li class="page-item <?php if($pageno >= $totalpage){echo "disabled" ;} ?>">
              <a href="<?php if($pageno>= $totalpage){echo 'disabled';}else{echo '?pageno='.($pageno+1);}?>" class="page-link">Next</a>
            </li>
            <li class="page-item"><a href="?pageno=<?php echo $totalpage ?>" class="page-link">Last</a></li>
            </ul>
    </div>
     <!-- / pagination -->
    <!--scroll to top -->
    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
    <!-- /. scroll to top -->
  <footer >
    <div class="container-fluid text-secondary"  style="margin-bottom: 80px;">
      <div class="float-right d-none d-sm-block">
      <a href="logout.php" class="btn btn-danger btn-md">Logout</a>
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
