<?php 
$title = 'View-students';
require_once 'includes/header.php';
require_once 'includes/std_header.php';
require_once 'db/conn.php';

if(isset($_GET['id'])){
    $sid = $_GET['id'];
    $result = $crud->getStudentDetails($sid);
}
else if(isset($_SESSION['sid'])){
    $sid = $_SESSION['sid'];
    $result = $crud->getStudentDetails($sid);
}
else {
    echo "<h1 class='text-danger text-center'>Check the details and try again</h1>";
}
?>

<div class="card mx-auto" style="width: 25rem;">
    <div class="card-body">
        <h5 class="card-title">
            <?php
            echo $result[1];
            ?>
        </h5>
        <h6 class="card-subtitle mb-2 text-muted">
            <?php
            echo $result[0];
            ?>
        </h6>
        <p class="card-text">
            <?php
            echo 'Department: ' . $result[3] . '</br>';
            echo 'Advisor ID: ' . $result[2] . '</br>';
            echo 'Level: ' . $result[6] . '</br>';
            echo 'Term: ' . $result[7] . '</br>';
            echo 'Present Address: '. $result[8] . ', '. $result[9] .'</br>';
            echo 'Registration Status: ' . $result[5].'</br>';
            if($result[4] != -1){
                echo 'Registration ID: ' . $result[4].'</br>';
            }
            ?>
        </p>
    </div>
</div>

<?php 
require_once 'includes/footer.php';
?>