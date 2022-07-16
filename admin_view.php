<?php 
$title = 'View-admin';
require_once 'includes/header.php';
require_once 'includes/admin_header.php';
require_once 'db/conn.php';

function getStd($ad, $L, $T){
    if(isset($_SESSION['ad_id']) && isset($_SESSION['dept_id'])){
        return $ad->getStudentsOfDept($_SESSION['dept_id'], ''.$L.'', ''.$T.'');
    }
    else    return null;
}

function calculate_gpa($crud, $sid, $L, $T){
    $grades = $crud->getGradesOf($sid, $L, $T);
    $tot_credit = 0;
    $tot_weighted_gp = 0;
    for($k = 0; $k < count($grades); $k++){
        $tot_credit += $grades[$k][2];
        $tot_weighted_gp += $grades[$k][4];
    }
    if($tot_credit != 0)    return round($tot_weighted_gp / $tot_credit, 2);
    else    return null;
}

if(isset($_GET['submit']) && isset($_GET['courses_selected']) && isset($_GET['selectLevel']) && isset($_GET['selectTerm']) && isset($_GET['students'])){
    $courses_selected = $_GET['courses_selected'];
    $levels_selected = $_GET['selectLevel'];
    $terms_selected = $_GET['selectTerm'];
    $students = $_GET['students'];
    $crud->insertIntoTakes($students, $_SESSION['dept_id'], $courses_selected, $levels_selected, $terms_selected);

    for($i = 0; $i < count($students); $i++){
        $crud->updateStudentInfo($students[$i], $_SESSION['dept_id'], $levels_selected[$i], $terms_selected[$i]);
    }
}

?>

<div class="accordion" id="accordionExample">
    <?php
        for($i = 1; $i <= 4; $i++){
            for($p = 1; $p <= 2; $p++){
            $students = getStd($admin, $i, $p);
    ?>

  <div class="accordion-item">
    <h2 class="accordion-header" id=<?php echo "heading".$i.$p;?>>
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target=<?php echo "#collapse".$i.$p;?> aria-expanded="false" aria-controls=<?php echo "collapse".$i.$p;?>>
        Level - <?php echo $i;?>   Term - <?php echo $p;?>
      </button>
    </h2>
    <div id=<?php echo "collapse".$i.$p;?> class="accordion-collapse collapse" aria-labelledby=<?php echo "heading".$i.$p;?> data-bs-parent="#accordionExample">
      <div class="accordion-body">
            <form method="get" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
                <table class="table table-dark table-hover">
                    <th>Student ID</th>
                    <th>Level</th>
                    <th>Term</th>
                    <th>GPA</th>
                    <th>Registration Status</th>
                    <?php
                        
                        for($j = 0; $j < count($students); $j++){
                            if(calculate_gpa($crud, $students[$j][0], $i, $p) != null && calculate_gpa($crud, $students[$j][0], $i, $p) > 0.0){
                    ?>
                    <input type="hidden" name="students[]" value="<?php echo $students[$j][0];?>" />
                        <tr>
                            <td><?php echo $students[$j][0];?></td>
                            <td>
                                <select class="form-select" name="selectLevel[]">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-select" name="selectTerm[]">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                </select>
                            </td>
                            <td>
                                <?php
                                    echo calculate_gpa($crud, $students[$j][0], $i, $p);
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo ($crud->getRegStatus($students[$j][0]))[0];
                                ?>
                            </td>
                        </tr>
                    <?php } } ?>
                </table>

                <?php
                    if(isset($_GET['load']) && isset($_SESSION['dept_id'])){
                        $courses = $crud->getCoursesOfferedBy($_SESSION['dept_id']);

                        for($k = 0; $k < count($courses); $k++){
                ?>

                <div class="form-check">           
                    <input class="form-check-input" type="checkbox" value="<?php echo $courses[$k][0]; ?>" name="courses_selected[]">
                    <label class="form-check-label">
                        <?php echo $courses[$k][0]; ?>
                    </label>
                </div>

                <?php }} ?>
                
                <div class="d-flex flex-row mb-3 justify-content-evenly">
                    <input class="btn btn-outline-primary" type="submit" value="Save Changes" name="submit">
                    <input class="btn btn-outline-primary" type="submit" value="Load Courses" name="load">
                </div>
            </form>
            
      </div>
    </div>
  </div>

    <?php }} ?>
</div>


<?php 
require_once 'includes/footer.php';
?>