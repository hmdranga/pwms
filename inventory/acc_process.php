<?php
include '../helper.php';
include '../conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Define variables----------------------------------------------------------
    $acc_type = $acc_min_qty = $property = null;
    //Assign data to sessons ---------------------------------------------------
     $acc_type = clean_input($_POST['acc_type']);   // accessory type id
     
    $acc_min_qty = clean_input($_POST['acc_min_qty']);
    $e = 1;
    $sql = "SELECT tb_product_property.property_id, tb_product_property.property 
        FROM tb_accessory_type_property 
        LEFT JOIN tb_product_property ON tb_product_property.property_id=tb_accessory_type_property.property_id 
        WHERE tb_accessory_type_property.accessory_type_id='" . $acc_type . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // property value id------------------------------------------------ 
             $pro_val_id = $_POST[strtolower(str_replace(" ", "_", $row['property']))];

            //empty validation-------------------------------------------------- 
            if (empty($pro_val_id)) {
                echo"<div class='alert alert-danger'>" . $row['property'] . " shoud not be empty</div>";
                $e = 0;
            } else {
                $sql_val[] = "Insert into tb_accessory_property(accessory_id,property_id,property_value_id) values('#','" . $row['property_id'] . "','" . $pro_val_id . "')";
            }
        }
    }
    ?>

    <?php

//-----------------------------------validation---------------------------------
    /*
      ------------validation format---------------------------------------------
     * 
      if(empty(variable)){
      ----empty validation-------
      }else{
      ----advanced validation----
      }
     */

    if (empty($acc_type)) {
        echo"<div class='alert alert-danger'>Accessory Type  shoud not be empty</div>";
        $e = 0;
    }

    if (empty($acc_min_qty)) {
        echo"<div class='alert alert-danger'>Minimum quantity shoud not be empty</div>";
        $e = 0;
    } else {
        if ($acc_min_qty < 0) {
            echo"<div class='alert alert-danger'>Minimum quantity invalid</div>";
            $e = 0;
        }
    }


// -----------------------end validation----------------------------------------


    if ($e == 1) {
        $sql_acc = "INSERT INTO `tb_accessory`( `accessory_type_id`, `min_qty`)"
                . "VALUES('$acc_type','$acc_min_qty')";
        
        if ($conn->query($sql_acc) === TRUE) {
            $acc_id = $conn->insert_id;
            foreach ($sql_val as $sql_property_value) {
                $sql_property_value = str_replace("#", "$acc_id", $sql_property_value);
                if ($conn->query($sql_property_value) == true) {
//                     echo"<div class='alert alert-success'>Registration is done..!</div>";
                } else {
                    echo "Error: " . $sql_property_value . "<br>" . $conn->error;
                }
            }
            
            
            ?>
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success!</strong>Accessory Add successfully..!
            </div>

            <?php
           
        } else {
            echo "Error: " . $sql_acc . "<br>" . $conn->error;
        }
    }
}
?>