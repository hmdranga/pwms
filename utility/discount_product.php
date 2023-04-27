<?php
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

     $discount = $product = null;
   

    $product = $_POST['product'];
    $discount = $_POST['discount'];

    $e = 1;

    if (empty($product)) {
        echo"<div class='alert alert-danger'>product shoud not be empty</div>";
        $e = 0;
    }
    
    if (empty($discount)) {
        echo"<div class='alert alert-danger'>discount shoud not be empty</div>";
        $e = 0;
    }
//    if (!empty($discount)) {
//        if (!is_numeric($discount)) {
//             echo"<div class='alert alert-danger'>discount invalid</div>";
//             $e = 0;
//        }
//        if ($discount<=1 || $discount>=75) {
//             echo"<div class='alert alert-danger'>discount invalid*</div>";
//             $e = 0;
//        }
//    }


    if ($e == 1) {
        
        $sql = "INSERT INTO `tb_product_discount`( `discount`, `product_id`) VALUES ('$discount','$product')";
        $conn->query($sql);
        echo"<div class='alert alert-success'>discount product assigned..!</div>";
    }
}
?>