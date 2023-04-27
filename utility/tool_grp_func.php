<?php

include '../helper.php';
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $grp = $func = null;

    $grp = clean_input($_POST['tool_grp']);
    $func = clean_input($_POST['func_id']);

    $e = 1;
//empty validation
    if (empty($grp)) {
        echo"<div class='alert alert-danger'>Tool group shoud not be empty</div>";
        $e = 0;
    }
    if (empty($func)) {
        echo"<div class='alert alert-danger'>Tool function shoud not be empty</div>";
        $e = 0;
    }
    //empty validation end
    // already exsist vlidation
    if (!empty($grp) && !empty($func)) {
    $sql = "SELECT `tool_group_function_id`, `group_code`, `function_id` FROM `tb_tool_group_function` WHERE group_code = '$grp' AND `function_id`= '$func'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo"<div class='alert alert-danger'>function is already exist..</div>";
             $e = 0;
        }
    }


    if ($e == 1) {
        $sql = "INSERT INTO `tb_tool_group_function`( `group_code`, `function_id`) VALUES ('$grp','$func')";
        $conn->query($sql);
        echo"<div class='alert alert-success'>Tool-Group Function Assigned..!</div>";
    }
}
?>
