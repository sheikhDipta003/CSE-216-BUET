<?php 
$title = 'Registration';
require_once 'includes/header.php';
require_once 'includes/std_header.php';
require_once 'db/conn.php';

if(isset($_GET['id'])){
    $sid = $_GET['id'];
    $courses = $crud->getCoursesForReg($sid);
    $reg_status = $crud->getRegStatus($sid);
}
else if(isset($_SESSION['sid'])){
    $sid = $_SESSION['sid'];
    $courses = $crud->getCoursesForReg($sid);
    $reg_status = $crud->getRegStatus($sid);
}
else {
    echo "<h1 class='text-danger text-center'>Check the details and try again</h1>";
}

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['courses_selected'])){
    $courses_selected = $_GET['courses_selected'];
    // for ($i = 0; $i < count($courses_selected); $i++){ 
    //     echo $courses_selected[$i]."<br />";
    // }
    $crud->updateRegReq($_SESSION['sid'], $courses_selected);
    $_SESSION['req_sent'] = 'T';
}
?>
<form method="get" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
    <table class="table table-dark table-hover">
    <?php
        if(!isset($_SESSION['req_sent'])) echo '<th>Select</th>';
    ?>
    <th>Course ID</th>
    <th>Course Name</th>
    <th>Credit Hour</th>
    <?php
        if(isset($_SESSION['req_sent'])) echo '<th>Registration Status</th>';
    ?>
    <?php
            for($i = 0; $i < count($courses); $i++){
        ?>

        <tr>
            <?php
                if(!isset($_SESSION['req_sent'])) {
            ?>
                <td> <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?php echo $courses[$i][0]; ?>" name="courses_selected[]">
                        </div> 
                </td>
            <?php } ?>
            <td><?php echo $courses[$i][0]; ?></td>
            <td><?php echo $courses[$i][1]; ?></td>
            <td><?php echo $courses[$i][2]; ?></td>
            <?php
                if(isset($_SESSION['req_sent'])) {
            ?>
            <td><?php echo $reg_status[0]; ?></td>
            <?php } ?>
        </tr>

    <?php } ?>
    </table>

    <?php
        if(!isset($_SESSION['req_sent'])) {
    ?>
    <div class="d-flex flex-row mb-3 justify-content-evenly">
        <input class="btn btn-outline-dark" type="submit" value="Submit">
    </div>
    <?php } ?>
</form>

<?php 
require_once 'includes/footer.php';
?>