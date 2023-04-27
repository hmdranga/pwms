<?php
include '../helper.php';
include '../conn.php';
//Check Page Request Method post and update status 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Define variables
    $accessory_id = $type_id = null;
    //define arry for display error messages
    $e = 1;
    //Assign Data---------------------------------------------------------------
    $acc_id = $_POST['accessory_id'];
    $acc_min_qty = clean_input($_POST['acc_min_qty']); 
    //End assign data-----------------------------------------------------------
    
    //Check input fields are empty----------------------------------------------
    if (empty($acc_min_qty)) {
          echo"<div class='alert alert-danger'>Minimum quantity shoud not be empty</div>";
          $e =0;
    } 
    //End check input fields are empty------------------------------------------
    //Advance validation--------------------------------------------------------
   if (!empty($acc_min_qty)){
       if ($acc_min_qty < 0) {
            echo"<div class='alert alert-danger'>Minimum quantity invalid</div>";
            $e =0;
        }
   }
    //End advance validation----------------------------------------------------
    
    //database connectivity-----------------------------------------------------
    if ($e == 1) {
        $sql = "UPDATE `tb_accessory` SET `min_qty`= '$acc_min_qty'  WHERE `accessory_id`= $acc_id";
        if ($conn->query($sql) === true) {
            //header("Refresh:3");
             echo"<div class='alert alert-success'>Accessory minimum quntity updated successfully..!</div>";
             echo '<meta http-equiv="refresh" content="1">';
        } else {
            echo "Error: " . $sql_acc . "<br>" . $conn->error;
        }
    }
    //end data send to database-------------------------------------------------
}
?>