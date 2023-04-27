<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "yes") {
    $user_id = $profile_image = null;
    $user_id = $_POST['user_id'];
    $profile_image = $_POST['profile_image'];
    $sql_user_module = "DELETE FROM `tb_user_module` WHERE user_id = '$user_id'";
    $conn-> query($sql_user_module);
    $sql = "DELETE FROM tb_user WHERE user_id='$user_id'";
    $conn->query($sql);
    if ($profile_image != NULL) {
        unlink("../images/" .$profile_image);
    }
    header('Location:create_user.php');
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "no") {
    header('Location:create_user.php');
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
                    <input type="hidden" name="user_id" value="<?php echo $_POST['user_id']; ?>">
                    <input type="hidden" name="profile_image" value="<?php echo $_POST['profile_image']; ?>">
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


