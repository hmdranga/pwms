<?php

include '../helper.php';
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $group = null;

    $group = clean_input($_POST['group']);

    $e = 1;

    if (empty($group)) {
        echo"<div class='alert alert-danger'>tool group name shoud not be empty</div>";
        $e = 0;
    }
    if (!empty($group)) {
        if (!preg_match("/^[a-zA-Z]*$/", $group)) {
            echo"<div class='alert alert-danger'>tool group name is invalid...!</div>";
            $e = 0;
        }
    }


    if ($e == 1) {
        $sql = "INSERT INTO `tb_tool_group`( `group`) VALUES ('$group')";
        $conn->query($sql);
        echo"<div class='alert alert-success'>Tool Group Added..!</div>";
        echo '<meta http-equiv="refresh" content="1">';
    }
}
?>