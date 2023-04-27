<?php
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $trending_product = null;

    echo $trending_product = $_POST['product'];

    $e = 1;

    if (empty($trending_product)) {
        echo"<div class='alert alert-danger'>product shoud not be empty</div>";
        $e = 0;
    }
    


    if ($e == 1) {
        
        $sql = "INSERT INTO `tb_product_trending`( `product_id`) VALUES ('$trending_product')";
        $conn->query($sql);
        echo"<div class='alert alert-success'>trendig product assigned..!</div>";
    }
}
?>