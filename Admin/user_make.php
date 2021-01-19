<?php
  session_start();
  require_once("../config/config.php");
  require_once("../config/common.php");


  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header("location:login.php");
  }
  if($_SESSION['role'] != 1){
    header("location: login.php");
  }
  if($_POST) {
    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password'])<5){
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
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
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
              <input name="_token" type="hidden" value="<?php echo empty($_SESSION['_token']) ? '' : $_SESSION['_token']; ?>">
                <div class="form-group">
                    <label for="">Name</label>
                    <small class="text-danger d-block"><?php echo empty($nameError) ? '': '*'.$nameError; ?></small>
                    <input type="text" class="form-control <?php echo empty($nameError) ? '' : 'is-invalid'; ?>" name="name">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <small class="text-danger d-block"><?php echo empty($emailError) ? '': '*'.$emailError; ?></small>
                    <input type="email" class="form-control <?php echo empty($emailError) ? '' : 'is-invalid'; ?>" name="email">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <small class="text-danger d-block"><?php echo empty($passwordError) ? '': '*'.$passwordError; ?></small>
                    <input type="password" class="form-control <?php echo empty($passwordError) ? '' : 'is-invalid'; ?>" name="password">
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