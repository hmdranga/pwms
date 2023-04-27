<?php

include '../helper.php';
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $type = null;

   $type = clean_input($_POST['acc_type']);

    $e = 1;

    if (empty($type)) {
        echo"<div class='alert alert-danger'>Accessory type name shoud not be empty</div>";
        $e = 0;
    }
    if (!empty($type)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $type)) {
            echo"<div class='alert alert-danger'>Accessory type name is invalid...!</div>";
            $e = 0;
        }
    }

    if ($e == 1) {
        $sql = "INSERT INTO `tb_accessory_type`( `name`) VALUES ('$type')";
        $conn->query($sql);
        echo"<div class='alert alert-success'>Accessory type Added..!</div>";
    }
}
?>