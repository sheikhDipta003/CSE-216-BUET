<?php
$title = 'index';
require_once 'includes/header.php'; 
?>
<body style="background-image:url('https://assets.weforum.org/article/image/_sNw0oZO6IQV_vLpSbxFnx44SN_obtJrNdbSk0_yFFk.JPG'); background-size: 100vw 100vh; background-repeat: no-repeat;">
     <div class="d-flex justify-content-evenly" style="transform: translateY(50%);">
        <div class="card text-center text-bg-dark" style="width: 18rem;">
            <img src="images/admin.png" class="card-img-top" alt="Index page">
            <div class="card-body">
                <a href="std_login.php" class="btn btn-primary">Visit</a>
            </div>
        </div>
        <div class="card text-center text-bg-warning" style="width: 18rem;">
            <img src="images/teacher.png" class="card-img-top" alt="Index page">
            <div class="card-body">
                <a href="std_login.php" class="btn btn-primary">Visit</a>
            </div>
        </div>
        <div class="card text-center text-bg-success" style="width: 18rem;">
            <img src="images/student.png" class="card-img-top" alt="Index page">
            <div class="card-body">
                <a href="std_login.php" class="btn btn-primary">Visit</a>
            </div>
        </div>
    </div>

<?php 
require_once 'includes/footer.php';
?>