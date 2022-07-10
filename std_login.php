<?php 
$title = 'Login';
require_once 'includes/header.php';
require_once 'db/conn.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $inputid = trim($_POST['id']);
    $inputpass = $_POST['pass'];
    $result1 = $std->getStudent($inputid, $inputpass);
    $result2 = $teach->getTeacher($inputid, $inputpass);

    if(!$result1 && !$result2){
        echo '<div class="d-flex flex-row justify-content-evenly">
        <div class="toast show align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true" >
                <div class="d-flex">
                    <div class="toast-body">
                    Wrong student id or password
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>';
    }
    else if($result1){
        $_SESSION['sid'] = $_POST['id'];
        $url = 'http://localhost/term_project_sql/std_view.php?id='.$_POST['id'];
        if (!headers_sent()) { // check headers - you can not send headers if they already sent
            header('Location: ' . $url);
            exit; // protects from code being executed after redirect request
        } else {
            throw new Exception('Cannot redirect, headers already sent');
        }
    }
    else if($result2){
      $_SESSION['tid'] = $_POST['id'];
      $url = 'http://localhost/term_project_sql/teacher_view.php?id='.$_POST['id'];
      if (!headers_sent()) { // check headers - you can not send headers if they already sent
          header('Location: ' . $url);
          exit; // protects from code being executed after redirect request
      } else {
          throw new Exception('Cannot redirect, headers already sent');
      }
    }
}
?>

<div class="d-flex flex-column justify-content-evenly" style="height:100vh; width: 100vw; background-color:#222f3e;">
<div class="d-flex flex-row justify-content-evenly">
  <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
      <div class="d-flex flex-column mb-3" style="width: 30vw;">
        <div class="mb-3">
          <label for="id" class="form-label" style="font-family: 'Lucida Bright', Georgia, serif; font-size: 20px; font-style: normal; color: #fff200;">ID</label>
          <input type="text" class="form-control" id="id" name="id" style="border-top:0; border-left:0; border-right:0;">
        </div>
        <div class="mb-3">
          <label for="pass" class="form-label" style="font-family: 'Lucida Bright', Georgia, serif; font-size: 20px; font-style: normal; color: #fff200;">Password</label>
          <input type="password" class="form-control" id="pass" name="pass">
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
      </div>
    </form>
</div>
</div>

<?php 
require_once 'includes/footer.php';
?>