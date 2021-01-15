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
    $name = $_POST['name'];
    $email = $_POST['email'];
    if(empty($_POST['role'])){
      $role = 0;
    } else {
      $role = 1;
    }
    $id = $_GET['id'];
    $stat1 = $pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
    $stat1->execute([":email"=>$email , ":id"=>$id]);
    $stat1_res = $stat1->fetch(PDO::FETCH_ASSOC);
    if($stat1_res){
        echo "<script>alert('Someone used this email');</script>";
    } else {
        $stat2 = $pdo->prepare("UPDATE users SET name='$name' , email='$email', role='$role' WHERE id=$id");
        $result = $stat2->execute();
        if($result) {
          echo "<script>alert('Update Success');window.location.href='user_mana.php';</script>";
        }
    }
  }
  $stat1 = $pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
  $stat1->execute();
  $stat1_res = $stat1->fetchAll();
  include_once('header.php');
?>
  
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
            <h2>Edit User</h2>
        <div class="row">
          <div class="col-md-12">
            <form action="" method="post">
                <input type="hidden" name="id">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" 
                    value="<?php echo $stat1_res[0]['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control" name="email"
                    value="<?php echo $stat1_res[0]['email']; ?>" required>
                </div>
                <div class="form-check mb-3">
                  <input type="checkbox" class="form-check-input" name="role" value="1" 
                  <?php if($stat1_res[0]['role'] == 1){echo "checked"; }?>>
                  <label class="form-check-label"> : Check IF you want to make Admin</label>
                </div>
                <input type="submit" class="btn btn-success">
                <a href="user_mana.php" class="btn btn-warning">Back</a>
            </form>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php require_once('footer.html'); ?>