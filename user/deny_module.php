<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "yes") {
    echo $module_id = $_POST['module_id'];
    echo $user_id = $_POST['user_id'];
    $sql = "DELETE FROM tb_user_module WHERE module_id='$module_id' AND user_id ='$user_id' ";
    $conn->query($sql);
    header('Location:assign_module.php');
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "no") {
    header('Location:assign_module.php');
}
?>
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-6">

            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Delete Confirmation</h4>
                <p>Do you want to delete this record?</p>
                <hr>
                <p class="mb-0">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <input type="hidden" name="module_id" value="<?php echo $_POST['module_id']; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $_POST['user_id']; ?>">
                    <button type="submit" name="operate" value="yes"  class="btn btn-warning">YES</button>
                    <button type="submit" name="operate" value="no" class="btn btn-success">NO</button>
                </form>
                </p>
            </div>

        </div>
    </div>
</div>
<?php include '../footer.php'; ?>
<?php
ob_end_flush();
?>
