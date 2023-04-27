<?php
@session_start();
include '../conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Define variables----------------------------------------------------------
    $acc_type = $acc_min_qty = $property = $sql_pro_val_in = $_SESSION['sql_search'] = null;
    //Assign data to sessons ---------------------------------------------------
     $acc_type =$_POST['acc_type'];   // accessory type id
     //$acc_min_qty = clean_input($_POST['acc_min_qty']);
    $e = 1;
    //select accessory properties according to accessory type
    $sql = "SELECT tb_product_property.property_id, tb_product_property.property 
            FROM tb_accessory_type_property 
            LEFT JOIN tb_product_property ON tb_product_property.property_id=tb_accessory_type_property.property_id 
            WHERE tb_accessory_type_property.accessory_type_id='" . $acc_type . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // property value id catch from accessory.php
             $pro_val_id = $_POST[strtolower(str_replace(" ", "_", $row['property']))];
            //empty validation 
            if (empty($pro_val_id)) {
                echo"<div class='alert alert-danger'>" . $row['property'] . " shoud not be empty</div>";
                $e = 0;
            } else {
                 $sql_pro_val_in .= " accessory_id IN (SELECT accessory_id 
                                      FROM tb_accessory_property WHERE property_id = ".$row['property_id']." 
                                      AND property_value_id = $pro_val_id) AND";
               
            }
        }
    }
    $sql_pro_val_in = rtrim($sql_pro_val_in,"AND") ;
    //validation--------------------------------------------------------------------
    /*
      ------------validation format---------------------------------------------
      if(empty(variable)){
      ----empty validation-------
      }else{
      ----advanced validation----
      }
     */
    if (empty($acc_type)) {
        echo "<div class='alert alert-danger alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Accessory Type  shoud not be empty..!</strong>
            </div>";
       
        $e = 0;
    }
    if (!empty($acc_min_qty)) { {
            if ($acc_min_qty < 0) {
               echo "<div class='alert alert-danger alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Minimum quantity invalid..!</strong>
            </div>";
               
                $e = 0;
            }
        }
    }
// -----------------------end validation----------------------------------------
//create search from database---------------------------------------------------
    if ($e == 1) {
        $sql = "SELECT `accessory_id`, `tb_accessory_type`.name,`min_qty`, tb_accessory_type.accessory_type_id 
                        FROM `tb_accessory` 
                        LEFT JOIN tb_accessory_type ON tb_accessory.accessory_type_id=tb_accessory_type.accessory_type_id 
                        WHERE tb_accessory_type.accessory_type_id = $acc_type AND ".$sql_pro_val_in;
       if ($conn->query($sql) == TRUE) {
          if ($conn->query($sql)->num_rows > 0) {
       $_SESSION['sql_search']= $sql;
       echo '<meta http-equiv="refresh" content="1">';
          }else{
              $_SESSION['sql_search']= $sql;
             echo "<div class='alert alert-danger alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Accessory is not available in the stock..!</strong>
            </div>";
//              echo"<div class='alert alert-danger'>Accessory is not available in the stock..!</div>";
             // echo '<meta http-equiv="refresh" content="3">';
          }
       
       }
    }
}
?>