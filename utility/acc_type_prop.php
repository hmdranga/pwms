<?php

include '../helper.php';
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $property_id = $acc_type_id = null;

    $prop_id = clean_input($_POST['prop_id']);
    $acc_type_id = clean_input($_POST['acc_type_id']);

    $e = 1;
//empty validation
    if (empty($prop_id)) {
        echo"<div class='alert alert-danger'>Property shoud not be empty</div>";
        $e = 0;
    }
    if (empty($acc_type_id)) {
        echo"<div class='alert alert-danger'>Accessory Type shoud not be empty</div>";
        $e = 0;
    }
    //empty validation end
    // already exsist vlidation
    if (!empty($prop_id) && !empty($acc_type_id)) {
    $sql = "SELECT `accessory_type_id`, property_id FROM `tb_accessory_type_property` WHERE accessory_type_id = '$acc_type_id' AND `property_id`= '$prop_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo"<div class='alert alert-danger'>property is already exist..</div>";
             $e = 0;
        }
    }


    if ($e == 1) {
        $sql = "INSERT INTO `tb_accessory_type_property`(`accessory_type_id`, `property_id`) VALUES ('$acc_type_id','$prop_id')";
        $conn->query($sql);
        echo"<div class='alert alert-success'>Accessory-type Property Assigned..!</div>";
    }
}
?>