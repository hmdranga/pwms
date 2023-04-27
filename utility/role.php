<?php
include '../helper.php';
include '../conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Define variables
$role = null;

$role = clean_input($_POST['role']);

$e = 1;

if (empty($group)) {
    echo"<div class='alert alert-danger'>role name shoud not be empty</div>";
    $e = 0;
}
if (!empty($role)) {
    if (!preg_match("/^[a-zA-Z]*$/", $role)) {
        echo"<div class='alert alert-danger'>role name is invalid...!</div>";
        $e = 0;
    }
    $sql_rolename = "SELECT `group` FROM `tb_tool_group` WHERE `group`= '$role'";
    $result = $conn->query($sql_rolename);
    if ($result->num_rows > 0) {
        echo"<div class='alert alert-danger'>role name is already exist..</div>";
        $e = 0;
    }
}


if ($e == 1) {
    $sql = "INSERT INTO `tb_role`( `role`) VALUES ('$role')";
    $conn->query($sql);
    echo"<div class='alert alert-success'>emolyee role added..!</div>";
}

}