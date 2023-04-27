<?php

include '../helper.php';
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $property = $value= null;

    $property = $_POST['property'];
    $value = clean_input($_POST['product_value']);

    $e = 1;
//empty validation
    if (empty($property)) {
        echo"<div class='alert alert-danger'>property should not be empty</div>";
        $e = 0;
    }
    if (empty($value)) {
        echo"<div class='alert alert-danger'>value should not be empty</div>";
        $e = 0;
    }
    //empty validation end
    // already exsist vlidation
    if (!empty($property) && !empty($value)) {
                 
    $sql_value = "SELECT `property_id`, `value` FROM `tb_product_property_value` WHERE `property_id`= '$property' AND `value`= '$value'";
        $result = $conn->query($sql_value);
        if ($result->num_rows > 0) {
            echo"<div class='alert alert-danger'>value is already exist..</div>";
             $e = 0;
        }
    }


    if ($e == 1) {
        $sql = "INSERT INTO `tb_product_property_value`(`property_id`, `value`) VALUES ('$property','$value')";
        $conn->query($sql);
        echo"<div class='alert alert-success'>Value inserted..!</div>";
    }
}
?>