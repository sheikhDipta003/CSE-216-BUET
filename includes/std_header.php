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
        <li class="nav-item">
          <a class="nav-link active" href="#">View Grades</a>
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