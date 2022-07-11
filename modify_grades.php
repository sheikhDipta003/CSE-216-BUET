<?php 
$title = 'Modify-grades';
require_once 'includes/header.php';
require_once 'includes/teach_header.php';
require_once 'db/conn.php';

if(isset($_GET['id'])){
    $tid = $_GET['id'];
    $courses_delivered = $crud->getCoursesDeliveredBy($tid);
}
else if(isset($_SESSION['tid'])){
    $tid = $_SESSION['tid'];
    $courses_delivered = $crud->getCoursesDeliveredBy($tid);
}
else {
    echo "<h1 class='text-danger text-center'>Check the details and try again</h1>";
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selectSID']) && isset($_POST['selectCID']) && isset($_POST['selectGrade'])){
    $crud->updateGradesOf($_POST['selectSID'], $_POST['selectCID'], $tid, $_POST['selectGrade']);
}
?>

<div class="accordion" id="accordionExample">
    <?php
        for($i = 0; $i < count($courses_delivered); $i++){
    ?>

    <div class="accordion-item">
        <h2 class="accordion-header" id=<?php echo 'heading-'.$i; ?>>
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target=<?php echo '#collapse-'.$i; ?> aria-expanded="false" aria-controls="collapseOne">
            <?php echo $courses_delivered[$i][0].' - '.$courses_delivered[$i][1].' - '.$courses_delivered[$i][2].' credit'; 
                $students = $crud->getStudentsOf($tid, $courses_delivered[$i][0]);
            ?>
        </button>
        </h2>
        <div id=<?php echo 'collapse-'.$i; ?> class="accordion-collapse collapse" aria-labelledby=<?php echo 'heading-'.$i; ?> data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
                <table class="table table-dark table-hover">
                    <th>Student ID</th>
                    <th>Course ID</th>
                    <th>Change Grades</th>
                    <th class='text-center'>Action</th>
                    <tr>
                        <td>
                            <select class="form-select" name="selectSID">
                            <?php
                                for($j = 0; $j < count($students); $j++){
                            ?>
                            <option value=<?php echo $students[$j][0]; ?>><?php echo $students[$j][0]; ?></option>
                            <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select class="form-select" name="selectCID">
                            <option value=<?php echo $courses_delivered[$i][0]; ?>><?php echo $courses_delivered[$i][0]; ?></option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select" name="selectGrade">
                            <option selected>4</option>
                            <option value="3.75">3.75</option>
                            <option value="3.50">3.50</option>
                            <option value="3.25">3.25</option>
                            <option value="3.00">3.00</option>
                            <option value="2.75">2.75</option>
                            <option value="2.50">2.50</option>
                            <option value="2.25">2.25</option>
                            <option value="2.00">2.00</option>
                            <option value="0.00">0.00</option>
                            </select>
                        </td>
                        <td>
                            <div class="d-flex flex-row mb-3 justify-content-evenly">
                                <input class="btn btn-outline-primary" type="submit" value="Save Changes">
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        </div>
    </div>

    <?php } ?>
</div>

<?php 
require_once 'includes/footer.php';
?>