<?php 
$title = 'View-teachers';
require_once 'includes/header.php';
require_once 'includes/teach_header.php';
require_once 'db/conn.php';

if(isset($_GET['id'])){
    $tid = $_GET['id'];
    $result = $crud->getTeacherDetails($tid);
}
else if(isset($_SESSION['tid'])){
    $tid = $_SESSION['tid'];
    $result = $crud->getTeacherDetails($tid);
}
else {
    echo "<h1 class='text-danger text-center'>Check the details and try again</h1>";
}
?>

<div class="card mx-auto" style="width: 25rem;">
    <div class="card-body">
        <h5 class="card-title">
            <?php
            echo $result[2];
            ?>
        </h5>
        <h6 class="card-subtitle mb-2 text-muted">
            <?php
            echo $result[0];
            ?>
        </h6>
        <p class="card-text">
            <?php
            echo 'Department: ' . $result[1] . '</br>';
            echo 'Contact No.: ' . $result[3] . '</br>';
            echo 'Email: ' . $result[4].'</br>';
            echo 'Address: ' . $result[5].','.$result[6].'</br>';
            ?>
        </p>
    </div>
</div>


<?php 
require_once 'includes/footer.php';
?>