<?php
session_start();
require_once("config/config.php");
require_once("config/common.php");
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header("location:login.php");
}
if($_GET['id']){
  $statement = $pdo->prepare("SELECT * FROM `post` WHERE id=" . $_GET['id']);
  $statement->execute();
  $post = $statement->fetchAll();
}
if(!empty($_GET['pageno'])) {
  $pageno = $_GET['pageno'];
}

$blogid = $_GET['id'];
$comment_statement = $pdo->prepare("SELECT * FROM `comments` WHERE `post_id`=$blogid");
$comment_statement->execute();
$comment_res = $comment_statement->fetchall();
// $user_comment = [];
if($comment_res) {
 foreach($comment_res as $key=>$value) {
  $author_id = $comment_res[$key]['author_id'];
  $user_com = $pdo->prepare("SELECT * FROM `users` WHERE `id`=$author_id");
  $user_com->execute();
  $user_comment[] = $user_com->fetchAll();
 }
}
if ($_POST) {
  if(empty($_POST['comments'])){
    $comment_err = "You did not write anything";
  } else {
      $comments = $_POST['comments'];
    $statement = $pdo->prepare("INSERT INTO `comments` (`content` , `author_id` , `post_id`) VALUES 
    (:content, :author_id, :post_id)");
    $p_comment = $statement->execute(
      array(':content'=>$comments,':author_id'=>$_SESSION['user_id'],':post_id'=>$blogid));
    if ($p_comment) {
      header('location: blogdetail.php?id=' . $blogid. '&&pageno=' . $pageno);
    }  
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Blogs | Detail</title>
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
<div class="container mt-4">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <?php 
              if ($post) {
                foreach($post as $result){
            ?>
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <h3 class="text-center text-primary"><?php echo escape($result['title']); ?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <img class="img-fluid pad mx-auto d-block" src="Admin/images/<?php echo $result['image'];?>" alt="Photo">
                <p class="mt-5"><?php echo escape($result['content']);?></p>
                <?php
                    }
                  }
                ?>
                <h3>Comments</h3>
                <a href="<?php echo $_SESSION['role']== 1 ? "Admin/index.php" : "index.php?pageno=".$pageno; ?>" class="btn btn-success">Go Back</a>
              </div>
              <!-- /.card-body -->
              <div class="card-footer card-comments">
                <?php if($comment_res) { ?>
                <?php foreach($comment_res as $key=>$value){ ?>
                <div class="card-comment">
                  <div class="comment-text" style="margin-left : 0px !important;">
                    <span class="username">
                    <?php echo $user_comment[$key][0]['name']; ?>
                    </span><!-- /.username -->
                    <span class="text-muted float-right"><?php echo $value['created_at']; ?></span>
                    <?php echo $value['content']; ?>
                    </div>
                   <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->  
                <?php } ?>
                <?php } ?>
            </div>
              <!-- /.card-footer -->
                 
              <div class="card-footer">
                <form action="" method="post">
                <input name="_token" type="hidden" value="<?php echo empty($_SESSION['_token']) ? '' : $_SESSION['_token']; ?>">
                  <div class="img-push">
                    <input type="text" name="comments" class="form-control form-control-sm" placeholder="Press enter to post comment">
                    <small class="text-warning"><?=empty($comment_err) ? '' : '*'.$comment_err; ?></small>
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer>
    <div class="container mb-5 mt-3">
      <div class="float-right d-none d-sm-block">
        <a href="logout.php" class="btn btn-danger btn-md">Logout</a>
      </div>
      <strong>Copyright &copy; 2014-2019 <a href="">yellyint48@gmail.com</a>.</strong> All rights
      reserved.
    </div>
  </footer>

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
