    
<?php
    $title = 'Edit-info';
    require_once 'includes/header.php';
    require_once 'includes/std_header.php';
    require_once 'db/conn.php';

    if(isset($_POST['submit'])){
        $crud->updateStdInfo($_SESSION['sid'], $_POST['inputName'], $_POST['inputStAddr'], $_POST['inputDstr'], $_POST['inputPass']);
        header("Location: std_view.php");
    }

    if(isset($_SESSION['sid'])){
        $stdInfo = $crud->getStdPersonalInfo($_SESSION['sid']);
    
?>

<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">

<div class="mb-3 row">
    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputName" name="inputName" value="<?php echo trim($stdInfo[0]); ?>">
    </div>
</div>

<div class="mb-3 row">
    <label for="inputStAddr" class="col-sm-2 col-form-label">Street Address</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputStAddr" name="inputStAddr" value="<?php echo trim($stdInfo[2]); ?>">
    </div>
</div>

<div class="mb-3 row">
    <label for="inputDstr" class="col-sm-2 col-form-label">District</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputDstr" name="inputDstr" value="<?php echo trim($stdInfo[3]); ?>">
    </div>
</div>

<div class="mb-3 row">
    <label for="inputPass" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPass" name="inputPass" value="<?php echo trim($stdInfo[1]); ?>">
    </div>
</div>


<div class="mb-3 row">
    <button type="submit" class="btn btn-outline-primary" name="submit">Save Changes</button>
</div>

</form>

<?php }
require_once 'includes/footer.php';
?>