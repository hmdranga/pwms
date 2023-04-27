<?php

include '../helper.php';
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $prop = $func = null;

    $prop = clean_input($_POST['prop']);
    $func = clean_input($_POST['tool_func']);

    $e = 1;
//empty validation
    if (empty($prop)) {
        echo"<div class='alert alert-danger'>Property shoud not be empty</div>";
        $e = 0;
    }
    if (empty($func)) {
        echo"<div class='alert alert-danger'>Tool function shoud not be empty</div>";
        $e = 0;
    }
    //empty validation end
    // already exsist vlidation
    if (!empty($prop) && !empty($func)) {
    $sql = "SELECT * FROM `tb_function_property` WHERE function_id = '$func' AND `property_id`= '$prop'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo"<div class='alert alert-danger'>property is already exist..</div>";
             $e = 0;
        }
    }


    if ($e == 1) {
        $sql = "INSERT INTO `tb_function_property`( `function_id`, `property_id`) VALUES ('$func','$prop')";
        $conn->query($sql);
        echo"<div class='alert alert-success'>Function property assigned..!</div>";
    }
}
?>