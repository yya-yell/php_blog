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
    $password = $_POST['password'];
    if(empty($_POST['role'])){
      $role = 0;
    } else {
      $role = 1;
    }
    $stat1 = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stat1->bindValue(":email" , $email);
    $stat1->execute();
    $stat1_res = $stat1->fetch(PDO::FETCH_ASSOC);
    if($stat1_res) {
      echo "<script>alert('Invalid Infomation');</script>";
    } else {
      $stat2 = $pdo->prepare("INSERT INTO users (name , password , email , role) VALUES 
      (:name , :password , :email, :role)");
      $result = $stat2->execute([":name"=>$name , ":password"=>$password,  ":email"=>$email , ":role"=>$role]);
      if($result) {
        echo "<script>alert('Successfully add one person');window.location.href='user_mana.php';</script>";
      }
    }
  }
  include_once('header.php');
?>
  
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
            <h2>Create User</h2>
        <div class="row">
          <div class="col-md-12">
            <form action="user_make.php" method="post">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-check mb-3">
                  <input type="checkbox" class="form-check-input" name="role" value="1">
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