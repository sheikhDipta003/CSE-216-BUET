<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="std_view.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="registration.php">Registration</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            View Grades
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="std_view_grades.php?level=1&term=1">1-1</a></li>
            <li><a class="dropdown-item" href="std_view_grades.php?level=1&term=2">1-2</a></li>
            <li><a class="dropdown-item" href="std_view_grades.php?level=2&term=1">2-1</a></li>
            <li><a class="dropdown-item" href="std_view_grades.php?level=2&term=2">2-2</a></li>
            <li><a class="dropdown-item" href="std_view_grades.php?level=3&term=1">3-1</a></li>
            <li><a class="dropdown-item" href="std_view_grades.php?level=3&term=2">3-2</a></li>
            <li><a class="dropdown-item" href="std_view_grades.php?level=4&term=1">4-1</a></li>
            <li><a class="dropdown-item" href="std_view_grades.php?level=4&term=2">4-2</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Change Password</a>
        </li>
        <li class="nav-item">
            <?php 
                if(isset($_SESSION['sid'])){
            ?>
            <a class="nav-item nav-link active" href="logout.php">Logout </a>
            <?php } ?>
        </li>
      </ul>
    </div>
  </div>
</nav>