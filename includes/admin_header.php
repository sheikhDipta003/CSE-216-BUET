<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="admin_view.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="admin_view.php">Modify Course Assignment</a>
        </li>
        <li class="nav-item">
            <?php 
                if(isset($_SESSION['ad_id'])){
            ?>
            <a class="nav-item nav-link active" href="logout.php">Logout </a>
            <?php } ?>
        </li>
      </ul>
    </div>
  </div>
</nav>