<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="teacher_view.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="view_registrants.php">Registrants</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="modify_grades.php">Modify Grades</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Change Password</a>
        </li>
        <li class="nav-item">
            <?php 
                if(isset($_SESSION['tid'])){
            ?>
            <a class="nav-item nav-link active" href="logout.php">Logout </a>
            <?php } ?>
        </li>
      </ul>
    </div>
  </div>
</nav>