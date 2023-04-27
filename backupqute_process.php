<?php

include 'helper.php';
include 'conn.php';
print_r($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pro_id = $pro_qty = $d_address = $tp_no = $email = $d_comment = null;
     $pro_id = clean_input($_POST['pro_id']);
     $pro_qty = clean_input($_POST['pro_qty']);
     $d_comment = clean_input($_POST['d_comment']);
     $cus_name = clean_input($_POST['cus_name']);
     $d_address = clean_input($_POST['d_address']);
     $email = clean_input($_POST['email']);
     $tp_no = clean_input($_POST['tp_no']);
     


    $e = 1;
    $sql = "SELECT tb_product_property.property_id, tb_product_property.property, tb_product_property.type FROM tb_product_property_assign LEFT JOIN tb_product_property ON tb_product_property.property_id=tb_product_property_assign.property_id WHERE tb_product_property_assign.product_id = '$pro_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $property[] = array($row['property'], $row['type'], $row['property_id']);
        }

        $sql = null;

        foreach ($property as $value) {
            $pro_value = null;
             $field = strtolower(str_replace(" ", "_", $value[0]));
            if ($value[1] == "R") {
                if (isset($_POST[$field])) {
                    $pro_value = $_POST[$field];
                }
                if (empty($pro_value)) {
                    $x[$field]="<div class='alert alert-danger'>" . $value[0] . " shoud not be empty</div>";
//                    echo"<div class='alert alert-danger'>" . $value[0] . " shoud not be empty</div>";
                    $e = 0;
                } else {
                    $sql[] = "Insert into tb_order_property(order_id,property_id,value) values('#','" . $value[2] . "','" . $pro_value . "')";
                }
            }

            if ($value[1] == "C") {
                $pro_value = $_POST[$field];
                if (empty($pro_value)) {
//                    echo"<div class='alert alert-danger'>" . $value[0] . " shoud not be empty</div>";
                     $x[$field]="<div class='alert alert-danger'>" . $value[0] . " shoud not be empty</div>";
                    $e = 0;
                } else {
                    $sql[] = "Insert into tb_order_property(order_id,property_id,value) values('#','" . $value[2] . "','" . $pro_value . "')";
                }
            }

            if ($value[1] == "N") {
                $pro_value = $_POST[$field];
                if (empty($pro_value)) {
//                    echo"<div class='alert alert-danger'>" . $value[0] . " shoud not be empty</div>";
                     $x[$field] = "<div class='alert alert-danger'>" . $value[0] . " shoud not be empty</div>";
                    $e = 0;
                } else if (!is_numeric($pro_value)) {
                    $x[$field] = "<div class='alert alert-danger'>" . $value[0] . " shoud be number input</div>";
                    $e = 0;
                } else {
                    $sql[] = "Insert into tb_order_property(order_id,property_id,value) values('#','" . $value[2] . "','" . $pro_value . "')";
                }
            }
        }
    }


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
    if (empty($pro_qty)) {
        $x['pro_qty'] = "<div class='alert alert-danger'>Product quantity shoud not be empty</div>";
        $e = 0;
    } else {
        if ($pro_qty <= 0) {
            $x['pro_qty'] = "<div class='alert alert-danger'>Product quantity invalid</div>";
            $e = 0;
        }
    }

//    if (empty($d_comment)) {
//        $x['d_comment'] = "<div class='alert alert-danger'>Design Comment shoud not be empty</div>";
//        $e = 0;
//    }

    if (empty($cus_name)) {
       $x['cus_name'] = "<div class='alert alert-danger'>Name shoud not be empty</div>";
        $e = 0;
    } else {
        if (!preg_match("/^[a-zA-Z ]*$/", $cus_name)) {
            $x['cus_name'] = "<div class='alert alert-danger'>Name is invalid...!</div>";
            $e = 0;
        }
    }

//    if (empty($d_address)) {
//        $x['d_address'] = "<div class='alert alert-danger'>Delivery Address shoud not be empty</div>";
//        $e = 0;
//    }

    if (empty($email)) {
      $x['email'] = "<div class='alert alert-danger'>Email address shoud not be empty</div>";
        $e = 0;
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           $x['email'] = "<div class='alert alert-danger'>The Email address is invalid...!</div>";
            $e = 0;
        }
    }

//    if (empty($tp_no)) {
//        $x['tp_no'] = "<div class='alert alert-danger'>Telephone number shoud not be empty</div>";
//        $e = 0;
//    } else {
//        if (!preg_match("/^[0-9+]*$/", $tp_no)) {
//            $x['tp_no'] = "<div class='alert alert-danger'>The tlephone number is invalid...!</div>";
//            $e = 0;
//        }
//    }

// -----------------------end validation----------------------------------------


    if ($e == 1) {
        
      
            
           $x['quate'] ="<div class='alert alert-success'>Rs. 1500.00</div>";
           echo $msg = json_encode($x);
//            echo "New record created successfully. Last inserted ID is: " . $order_id;
        
    }else{
        
//        $x["paper_size"] = "paper size should not be blank";
//        $x["paper_thick"] = "paper thick should not be blank";
        
        echo $msg = json_encode($x);
        
    }
}
?>

