<?php
session_start();
require_once("../config/config.php");
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header("location:login.php");
}
if($_SESSION['role'] != 1){
  header("location: .login.php");
}
if ($_POST) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    if ($_FILES['file']['name'] != null){
        $file = "images/". $_FILES['file']['name'];
        $filetype = pathinfo($file , PATHINFO_EXTENSION);
        if($filetype != 'jpg' && $filetype != 'png' && $filetype != 'jpeg') {
            echo "<script>
                alert('Image must be JPG , PNG or JPEG');
                window.location.href='index.php';
                </script>";
        } else {
            $image = $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'] , $file);         
            $statement = $pdo->prepare("UPDATE `post` SET `image` = '$image' WHERE id = '$id'");
            $result = $statement->execute();
        }
    } 
    $statement = $pdo->prepare("UPDATE `post` SET `title`= '$title' , `content` = '$content' WHERE 
    id = $id");
    $result = $statement->execute();
    if ($result) {
        echo "<script>alert('Successfully Updated');window.location.href='index.php';</script>";
    }
}
$statement = $pdo->prepare("SELECT * FROM `post` WHERE id=" . $_GET['id']);
$statement->execute();
$post = $statement->fetchAll();
// var_dump($post);
?>
<?php include_once('header.php'); ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Blog Create</h3> <br>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $post[0]['id']; ?>">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control" 
                        value="<?php echo $post[0]['title']; ?>" required>
                    </div>   
                    <div class="form-group">
                        <label for="">Content</label>
                        <textarea name="content" class="form-control" id="" cols="30" rows="10" required>
                        <?php echo $post[0]['content']; ?>
                        </textarea>
                    </div>  
                    <div class="form-group">
                        <label for="">Image</label> <br>
                        <img src="images/<?php echo $post[0]['image']; ?>" class="w-25 mb-3" alt=""> <br>
                        <input type="file" name="file">
                    </div>  
                    <input type="submit" class="btn btn-success">    
                    <a href="index.php" class="btn btn-warning">Back</a>      
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php require_once('footer.html'); ?>