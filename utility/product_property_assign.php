<?php

include '../helper.php';
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $property = $product= $property_nm = $product_nm = null;

    $property = clean_input($_POST['property']);
    $product = clean_input($_POST['product']);
    $e = 1;
//empty validation
    if (empty($property)) {
        echo"<div class='alert alert-danger'>property shoud not be empty</div>";
        $e = 0;
    }
    if (empty($product)) {
        echo"<div class='alert alert-danger'>product shoud not be empty</div>";
        $e = 0;
    }
    //empty validation end
    
    if (!empty($product) && !empty($product)) {
        // already exsist vlidation
        $sql_assign = "SELECT `product_id`, `property_id` FROM `tb_product_property_assign` WHERE `product_id`= '$product' AND `property_id`= '$property'";
        $result = $conn->query($sql_assign);
        if ($result->num_rows > 0) {
            echo"<div class='alert alert-danger'>property is already exist..</div>";
             $e = 0;
        }
        
        $sql_nm = "SELECT `property` FROM `tb_product_property` WHERE `property_id` = '$property' ";
        $result_nm = $conn->query($sql_nm);
        if ($result_nm->num_rows > 0) {
            $row = $result_nm->fetch_assoc();
            $property_nm = $row['property'];
        }else{
            echo"<div class='alert alert-danger'>property is not exist..</div>";
            $e = 0;
        }
        $sql_nm = "SELECT `name` FROM `tb_product` WHERE `product_id` = '$product' ";
        $result_nm = $conn->query($sql_nm);
        if ($result_nm->num_rows > 0) {
            $row = $result_nm->fetch_assoc();
            $product_nm = $row['name'];
        }else{
            echo"<div class='alert alert-danger'>product is not exist..</div>";
            $e = 0;
        }
        
    }
    
    

    if ($e == 1) {
        $sql = "INSERT INTO `tb_product_property_assign`( `product_id`, `property_id`) VALUES ('$product','$property')";
        $conn->query($sql);
        
        echo"<div class='alert alert-success'> $property_nm Assigned to $product_nm..!</div>";
    }
}
?>