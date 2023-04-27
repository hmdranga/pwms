<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "yes") {
    $acc_id = null;
    $acc_id = $_POST['accessory_id'];
    $sql="DELETE FROM `tb_accessory_property` WHERE accessory_id = '$acc_id'";
    $conn-> query($sql);
    $sql = "DELETE FROM `tb_accessory` WHERE accessory_id =  '$acc_id'";
    $conn-> query($sql);
    header('Location:accessory.php');
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "no") {
    header('Location:accessory.php');
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
                    <input type="hidden" name="accessory_id" value="<?php echo $_POST['accessory_id']; ?>">
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

