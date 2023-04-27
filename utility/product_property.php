<?php

include '../helper.php';
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $property = $type = null;

    $property = clean_input($_POST['property']);
    if (isset( $_POST['Property_type'])) {
        $type = $_POST['Property_type'];
    }
    
    $e = 1;
    if (empty($type)) {
        echo"<div class='alert alert-danger'>type should not be empty</div>";
        $e = 0;
    }

    if (empty($property)) {
        echo"<div class='alert alert-danger'>tool group name should not be empty</div>";
        $e = 0;
    }
    if (!empty($property)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $property)) {
            echo"<div class='alert alert-danger'>tool property name is invalid...!</div>";
            $e = 0;
        }
    }


    if ($e == 1) {
        $sql = "INSERT INTO `tb_product_property`( `property`, `type`) VALUES ('$property','$type')";
        $conn->query($sql);
        echo"<div class='alert alert-success'>Product Property Added..!</div>";
    }
}
?>

