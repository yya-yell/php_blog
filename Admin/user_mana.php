<?php
session_start();
require_once("../config/config.php");
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header("location:login.php");
}
if($_SESSION['role'] != 1){
  header("location: login.php");
}
if (!empty($_POST['search'])) {
  setcookie('search', $_POST['search'], time() + (86400 * 30), "/"); 
} else {
  if(empty($_GET['pageno'])){
    unset($_COOKIE['search']); 
    setcookie('search', null, -1, '/'); 
  }
}
if(empty($_GET['pageno'])){
  $pageno = 1;
}else {
  $pageno = $_GET['pageno'];
}
$numOfrec = 2;
$offset = ($pageno - 1) * $numOfrec;

if(empty($_POST['search']) && empty($_COOKIE['search'])){
  $stat_1 = $pdo->prepare("SELECT * FROM users");
  $stat_1->execute();
  $stat_1_res = $stat_1->fetchAll();
  $totalpage = ceil(count($stat_1_res) / $numOfrec);
  $state = $pdo->prepare("SELECT * FROM users ORDER BY id DESC LIMIT $offset , $numOfrec ");
  $state->execute();
  $result = $state->fetchAll();
} else {
  if(!empty($_POST['search'])){
    $search = $_POST['search'];
  } else {
    if(!empty($_COOKIE['search'])) {
      $search = $_COOKIE['search'];
    }
  }
  $search_manu = $pdo->prepare("SELECT * FROM users WHERE name LIKE '%$search%' ORDER BY id DESC");
  $search_manu->execute();
  $search_res = $search_manu->fetchAll();
  $totalpage = ceil(count($search_res) / $numOfrec);
  $state_se = $pdo->prepare("SELECT * FROM users WHERE name LIKE '%$search%' ORDER BY id DESC LIMIT $offset,$numOfrec");
  $state_se->execute();
  $result = $state_se->fetchAll();
}



include_once('header.php');
?>
  
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>User Management</h2>
                    <a href="user_make.php" class="btn btn-success mt-2">Create User</a>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td style="width: 10px">#</td>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Role</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                              if($result){
                                  $i = 1;
                                  foreach($result as $people){
                            ?>
                              <tr>
                                  <td><?php echo $i ?></td>
                                  <td><?php echo $people['name']; ?></td>
                                  <td><?php echo $people['email']; ?></td>
                                  <td><?php echo $people['role'] == 1 ? "Admin" : "User" ; ?></td>
                                  <td>
                                      <a href="user_edit.php?id=<?php echo $people['id'];?>" class="btn btn-info btn-sm">Edit</a>
                                      <a href="delete_user.php?id=<?php echo $people['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete <?php echo $people['name']; ?>');">Delete</a>
                                  </td>
                              </tr>
                            <?php
                              $i++;
                                }
                              }
                            ?>
                                
                        </tbody>
                    </table>
                    <ul class="pagination justify-content-end mt-3">
                      <li class="page-item"> <a href="?pageno=1" class="page-link">First</a></li>
                      <li class="page-item <?php if($pageno <= 1){echo "disabled";} ?>"> 
                        <a href="<?php if($pageno <= 1){echo "disabled";}else{ echo "?pageno=".($pageno-1);}?>" class="page-link">
                          Previous
                        </a>
                      </li>
                      <li class="page-item"> <a href="" class="page-link"><?php echo $pageno; ?></a></li>
                      <li class="page-item <?php if($pageno >= $totalpage){echo "disabled";} ?>">
                        <a 
                          href="<?php if($pageno >= $totalpage){echo "disabled";}else{echo "?pageno=".($pageno+1);}?>" class="page-link">
                        Next</a>
                      </li>
                      <li class="page-item"><a href="?pageno=<?php echo $totalpage; ?>" class="page-link">End</a></li>
                    </ul>
                </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php require_once('footer.html'); ?>