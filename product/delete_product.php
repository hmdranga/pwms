<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "yes") {
    $product_id = $product_image = null;
    $product_id = $_POST['product_id'];
    $product_image = $_POST['product_image'];
    $sql_product_task = "DELETE FROM `tb_product_task` WHERE product_id = '$product_id'";
    $conn-> query($sql_product_task);
    $sql = "DELETE FROM tb_product WHERE product_id = '$product_id'";
    $conn->query($sql);
    unlink("../images/" .$product_image);
    header('Location:register.php');
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "no") {
    header('Location:register.php');
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
                    <input type="hidden" name="product_id" value="<?php echo $_POST['product_id']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $_POST['product_image']; ?>">
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