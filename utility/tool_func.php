<?php

include '../helper.php';
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $func = null;

   $func = clean_input($_POST['func_nm']);

    $e = 1;

    if (empty($func)) {
        echo"<div class='alert alert-danger'>Function name shoud not be empty</div>";
        $e = 0;
    }
    if (!empty($func)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $func)) {
            echo"<div class='alert alert-danger'>Tool function name is invalid...!</div>";
            $e = 0;
        }
    }

    if ($e == 1) {
        $sql = "INSERT INTO `tb_tool_function`( `name`) VALUES  ('$func')";
        $conn->query($sql);
        echo"<div class='alert alert-success'>Tool Function Added..!</div>";
    }
}
?>
