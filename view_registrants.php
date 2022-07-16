<?php 
$title = 'View-registrants';
require_once 'includes/header.php';
require_once 'includes/teach_header.php';
require_once 'db/conn.php';

if(isset($_GET['id'])){
    $tid = $_GET['id'];
    $advisees = $crud->getAdvisee($tid);
}
else if(isset($_SESSION['tid'])){
    $tid = $_SESSION['tid'];
    $advisees = $crud->getAdvisee($tid);
}
else {
    echo "<h1 class='text-danger text-center'>Check the details and try again</h1>";
}

for($i = 0; $i < count($advisees); $i++){
    if(isset($_POST['Approve-'.$advisees[$i][0]])){
        $crud->updateRegStatus($advisees[$i][0]);
        $crud->updateRegID($advisees[$i][0]);
    }
}
?>
<table class="table table-dark table-hover">
  <th>Student ID</th>
  <th>Student Name</th>
  <th>Action</th>
  <?php
        for($i = 0; $i < count($advisees); $i++){
    ?>
    <tr>
        <td><?php echo $advisees[$i][0]; ?></td>
        <td><?php echo $advisees[$i][1]; ?></td>
        <td>
            <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
                <input type="submit" class="btn btn-outline-warning" value='Approve' name=<?php echo 'Approve-'.$advisees[$i][0]; ?>>
                <button class="btn btn-outline-danger" type="button" data-bs-toggle="collapse" data-bs-target=<?php echo '#collapseExample-'.$advisees[$i][0]; ?> aria-expanded="false" aria-controls=<?php echo 'collapseExample-'.$advisees[$i][0]; ?>>
                    View Courses
                </button>
                <div class="collapse" id=<?php echo 'collapseExample-'.$advisees[$i][0]; ?>>
                    <?php 
                        if(isset($_SESSION['level']) && isset($_SESSION['term'])){
                        $result = $crud->getRegisteredCourses($advisees[$i][0], $_SESSION['level'], $_SESSION['term']);
                        for($j = 0; $j < count($result); $j++){
                    ?>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><?php echo $result[$j][0].'-'.$result[$j][1]; ?></li>
                        </ul>
                    <?php }} ?>
                </div>
            </form>
        </td>
    </tr>

  <?php } ?>
</table>

<?php 
require_once 'includes/footer.php';
?>