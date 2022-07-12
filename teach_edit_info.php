<?php 
$title = 'Edit-teachers';
require_once 'includes/header.php';
require_once 'includes/teach_header.php';
require_once 'db/conn.php';

if(isset($_POST['submit'])){
    $crud->updateTeachInfo($_SESSION['tid'], $_POST['inputName'], $_POST['inputContactNo'], $_POST['inputEmail'], $_POST['inputStAddr'], $_POST['inputDstr'], $_POST['inputPass']);
    header("Location: teacher_view.php");
}

if(isset($_SESSION['tid'])){
    $teachInfo = $crud->getTeachPersonalInfo($_SESSION['tid']);
?>

<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">

<div class="mb-3 row">
    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputName" name="inputName" value="<?php echo trim($teachInfo[0]); ?>">
    </div>
</div>

<div class="mb-3 row">
    <label for="inputContactNo" class="col-sm-2 col-form-label">Contact No.</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputContactNo" name="inputContactNo" value="<?php echo trim($teachInfo[1]); ?>">
    </div>
</div>

<div class="mb-3 row">
    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail" name="inputEmail" value="<?php echo trim($teachInfo[2]); ?>">
    </div>
</div>

<div class="mb-3 row">
    <label for="inputStAddr" class="col-sm-2 col-form-label">Street Address</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputStAddr" name="inputStAddr" value="<?php echo trim($teachInfo[4]); ?>">
    </div>
</div>

<div class="mb-3 row">
    <label for="inputDstr" class="col-sm-2 col-form-label">District</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputDstr" name="inputDstr" value="<?php echo trim($teachInfo[5]); ?>">
    </div>
</div>

<div class="mb-3 row">
    <label for="inputPass" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPass" name="inputPass" value="<?php echo trim($teachInfo[3]); ?>">
    </div>
</div>


<div class="mb-3 row">
    <button type="submit" class="btn btn-outline-primary" name="submit">Save Changes</button>
</div>

</form>

<?php }
require_once 'includes/footer.php';
?>