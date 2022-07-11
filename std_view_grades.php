<?php 
$title = 'View-grades';
require_once 'includes/header.php';
require_once 'includes/std_header.php';
require_once 'db/conn.php';

if(isset($_SESSION['sid']) && isset($_GET['level']) && isset($_GET['term'])){
    $grades = $crud->getGradesOf($_SESSION['sid'], $_GET['level'], $_GET['term']);
    $tot_credit = 0;
    $tot_weighted_gp = 0;
    for($i = 0; $i < count($grades); $i++){
        $tot_credit += $grades[$i][2];
        $tot_weighted_gp += $grades[$i][4];
    }
    if($tot_credit != 0)    $gpa = round($tot_weighted_gp / $tot_credit, 2);
    else    echo '<h1 class="text-danger text-center">You are not qualified to view grades of this term</h1>';
}
?>

<?php if($tot_credit != 0){ ?>
<table class="table table-dark table-hover">
  <th>Course ID</th>
  <th>Course Name</th>
  <th>Credit Hour</th>
  <th>Grade Point</th>
  <th>GPA</th>
    <?php for($i = 0; $i < count($grades); $i++){ ?>
    <tr>
        <td><?php echo $grades[$i][0]; ?></td>
        <td><?php echo $grades[$i][1]; ?></td>
        <td><?php echo $grades[$i][2]; ?></td>
        <td><?php echo $grades[$i][3]; ?></td>
        <td><?php if($i == 0)   echo $gpa; ?></td>
    </tr>
    <?php } ?>
</table>

<?php }
require_once 'includes/footer.php';
?>