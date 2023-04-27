<?php

include '../helper.php';
include '../conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $member_name = $member_address = $district = $services = null;

    $member_name = clean_input($_POST['member_nameb']);

    $member_address = clean_input($_POST['member_address']);

    $district = clean_input($_POST['district']);

    $services = clean_input($_POST['services']);
    $e=1;

    if (empty($member_name)) {
        echo"<div class='alert alert-danger'>Member name shoud not be empty</div>";
//        $e['search_type'] = "The search type should not be empty....!";
        $e=0;
    }
    if (empty($member_address)) {
        echo"<div class='alert alert-danger'>Member address shoud not be empty</div>";
        $e=0;
    }
    if (empty($district)) {
        echo"<div class='alert alert-danger'>District shoud not be empty</div>";
        $e=0;
    }
    if (empty($services)) {
        echo"<div class='alert alert-danger'>Services shoud not be empty</div>";
        $e=0;
    }
    
    if($e==1){
        $sql="INSERT INTO tb_registration(member_name,member_address,district,services)"
                . "VALUES('$member_name','$member_address','$district','$services')";
        $conn->query($sql);
        echo"<div class='alert alert-success'>Registration is done..!</div>";
    }
    
}

?>

