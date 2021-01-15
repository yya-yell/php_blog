<?php
session_start();
require_once("../config/config.php");
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header("location:login.php");
}
if($_SESSION['role'] != 1){
  header("location: login.php");
}
if($_POST) {
    $file = 'images/'.($_FILES['file']['name']);
    $filetype = pathinfo($file , PATHINFO_EXTENSION);
    if($filetype != 'jpg' && $filetype != 'png' && $filetype != 'jpeg') {
        echo "<script>alert('Image must be PNG or JPG');</script>";
    } else {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $file_name = $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'] , $file);
        $statement = $pdo->prepare("INSERT INTO `post` (`title` , `content` , `image` , `author_id`) 
        VALUES 
        (:title , :content, :image , :author_id)");
        $post_data = $statement->execute(
            [
                ':title'=> $title,
                ':content'=> $content,
                ':image'=>$file_name,
                ':author_id'=>$_SESSION['user_id']
            ]
        );
        if ($post_data) {
          echo "<script>
          alert('Blog Create Success');
          window.location.href='index.php';
          </script>";
        }
    }
}
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
                <form action="create.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>   
                    <div class="form-group">
                        <label for="">Content</label>
                        <textarea name="content" class="form-control" id="" cols="30" rows="10" required></textarea>
                    </div>  
                    <div class="form-group">
                        <label for="">Image</label> <br>
                        <input type="file" name="file" required>
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