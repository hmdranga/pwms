<?php

//
function clean_input($data = null) {
    //removes whitespace both side
    $data = trim($data);
    //remove backslashes
    $data = stripslashes($data);
    //remove html characters in the word
    $data = htmlspecialchars($data);
    return $data;
}

//
function password_input($data = null) {
    $data = trim($data);
    return $data;
}

//
function pro_name($pro_id = null) {
     include 'conn.php';
    $sql = "SELECT `name` FROM `tb_product` WHERE product_id = $pro_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['name'];
    }
}

//
function acc_type_id_to_nm($acc_typ_id = null) {
    include 'conn.php';
    $sql = "SELECT  `name` FROM `tb_accessory_type` WHERE `accessory_type_id`= $acc_typ_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['name'];
    }
}

function acc_id_to_type_nm($acc_id = null) {
    include 'conn.php';
    $sql = "SELECT `accessory_type_id` FROM `tb_accessory` WHERE `accessory_id` = $acc_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return acc_type_id_to_nm($row['accessory_type_id']);
    }
}


//methord overloading using with this function with func_get_arg and func_num_args inbuilt functions
function avlable_itm_max_price() {
    include 'conn.php';
    $numargs = func_num_args();
    // $numargs == 3
    if ($numargs >= 2) {
//creation of query for each item with passing parameters
        $sql_max_price = "SELECT * FROM `tb_stock` s ";
        for ($x = 1; $x < $numargs; $x++) {
            $sql_max_price .= " LEFT JOIN tb_accessory_property ap$x on s.accessory_id = ap$x.accessory_id ";
        }
        $sql_max_price .= " WHERE s.accessory_type_id = " . func_get_arg(0) . " ";
        for ($x = 1; $x < $numargs; $x++) {
            $sql_max_price .= " AND ap$x.property_value_id = " . func_get_arg($x) . " ";
        }
         $sql_max_price .= " AND s.remain_qty > 0 ORDER BY `s`.`unit_price` DESC LIMIT 1";

        $result = $conn->query($sql_max_price);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['unit_price'];
        } else {

//accessory type not in stock msg 
             echo "<div class='alert alert-danger'>The pointed " . acc_type_id_to_nm(func_get_arg(0)) . " not in the current stock</div>";
           
            return 0;
        }
    } else {
        echo "invalid available max price arguments";
    }
}

function pro_id_to_val($val_id = null) {
    include 'conn.php';
    $sql = "SELECT  `value` FROM `tb_product_property_value` WHERE property_value_id = $val_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['value'];
    } elseif ($result->num_rows == 0) {
        echo 'the pointed property not available';
    }
}

function prop_val_to_id($val = null) {
    include 'conn.php';
    $sql = "SELECT property_value_id  FROM `tb_product_property_value` WHERE  `value`= $val ORDER BY `tb_product_property_value`.`value` ASC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['property_value_id'];
    } elseif ($result->num_rows == 0) {
        echo 'the pointed property not available';
    }
}

function ink_qty($area = null, $surface = null) {
    return $area * $surface / 1000000;
}

function task_cost($task_id = null, $count = null) {
    include 'conn.php';
    $sql = "SELECT  `unit_cost` FROM `tb_tool_function` WHERE function_id = $task_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['unit_cost'] * $count;
    } elseif ($result->num_rows == 0) {
        echo 'the pointed task is not available';
    }
}

function sales_material_cost($matt_cost = null) {
    return $matt_cost * 1.3;
}


function stock_use($acc_id = null, $acc_qty = null, $order = null) {
    include 'conn.php';
     date_default_timezone_set('UTC');
    $today = date("Ymd");

// check stock available for the order------------------------------------------

//  end stock availablity-------------------------------------------------------      
//creation of query for each item with passing parameters
        $sql = "SELECT * FROM `tb_stock` s ";
        $sql .= " WHERE s.accessory_id = " . $acc_id . " ";
        $sql .= " AND s.remain_qty > 0 ORDER BY `s`.`ex_date` ASC ";
        $sql .= "LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $acc_type = $row['accessory_type_id'];
           //if stock has orderd qty else perchase order due qty
            if (stock_available_qty($acc_id) >= $acc_qty) {

                
                // if first stock has full qty of the order else tow or more stock has the qty
                if ($row['remain_qty'] >= $acc_qty) {

                  echo  $sql_up = "UPDATE `tb_stock` SET `remain_qty` = " . ($row['remain_qty'] - $acc_qty) . " WHERE stock_id = '" . $row['stock_id'] . "'";
                    $result = $conn->query($sql_up);
                    if ($result == true) {
                      echo  $sql ="INSERT INTO `tb_stock_use`( `stock_id`, `accessory_id`, `order_id`, `con_date`, `pos_qty`) VALUES ('".$row['stock_id']."','$acc_id','$order','$today','$acc_qty' )";
                        $result = $conn->query($sql);
                        if ($result == true) {
                            echo 'update';
                        }
                    }
                } else {
                    
                   $due_qty = $acc_qty-$row['remain_qty'];
                  echo $sql_up = "UPDATE `tb_stock` SET `remain_qty` = " . 0 . " WHERE stock_id = '" . $row['stock_id'] . "'";
                       $result = $conn->query($sql_up);
                if ($result == true) {
                   echo  $sql ="INSERT INTO `tb_stock_use`( `stock_id`, `accessory_id`, `order_id`, `con_date`, `pos_qty`) VALUES ('".$row['stock_id']."','$acc_id','$order','$today','".$row['remain_qty']."' )";
                        $result = $conn->query($sql);
                        if ($result == true) {
                            echo 'update';
                        }

                   stock_use($acc_id, $due_qty, $order);
                }
                }
            } else {
                
                $perchese_order_qty = $acc_qty - stock_available_qty($acc_id);
               
                $sql_a = "SELECT * FROM `tb_stock` WHERE accessory_id = $acc_id";
                $result_a = $conn->query($sql_a);
                if ($result_a -> num_rows > 0){
                    
                   while( $row_use = $result->fetch_assoc()){

                       $sql ="INSERT INTO `tb_stock_use`( `stock_id`, `accessory_id`, `order_id`, `con_date`, `pos_qty`) VALUES ('".$row_use['stock_id']."','$acc_id','$order','$today','".$row_use['remain_qty']."' )";
                        $result = $conn->query($sql);
                        if ($result == true) {
                           echo $sql = "UPDATE `tb_stock` SET `remain_qty` = " . 0 . " WHERE stock_id = '" .$row_use['stock_id']. "'";
                            $result = $conn->query($sql);
                            if ($result == true) {
                                echo "updated stock remain to 0";
                            }
                        }
                       
                   }
                    
                } 
     
               echo $sql = "INSERT INTO `tb_purchase_order`( `accessory_id`, `due_qty`, `status`) VALUES ('$acc_id','$perchese_order_qty','0')";
                $result = $conn->query($sql);
                if ($result == true) {
                    echo "Ordered production " . acc_type_id_to_nm($acc_type) . " is lower";
                }
            }
        } else {

//accessory type not in stock msg 
            echo "The pointed " . acc_id_to_type_nm($acc_id) . " not in the current stock";
        }
   
}

//}
//

//stock remain quntity of the given accessory id 
function stock_available_qty($acc_id = null) {
    // database connection 
     include 'conn.php';
     //sql statemet for calculate remain quantity 
    $sql = "SELECT SUM(remain_qty) as acc_count FROM `tb_stock` s 
            WHERE remain_qty > 0 AND accessory_id = $acc_id
            ORDER BY ex_date ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        //output result if success 
        return $row['acc_count'];
    } elseif ($result->num_rows == 0) {
        // error message
        echo 'the pointed parameters invalid';
    }
}

function remain_qty($remain_sq = null, $qty = null) {
    $remain = explode("#", $remain_sq);
    $remain_qty = $remain[0];
    $stock_id = $remain[1];
    if ($remain_qty >= $pro_qty) {
        
    } else {
        
    }
}

//function fifo($ = null, $issued_qty = null) {
//    include 'conn.php';
//    $create_date = date('Y-m-d');
//    $remain = 0;
//    $stock = check_available_stock($item_code, $types);
//    if (!empty($stock)) {
//        
//    }
//}
//function array_to_val_arggument($array = null){
//    
//}
function discount($pro_id = null){
     include 'conn.php';
    $discount = null;
    $sql = "SELECT * FROM `tb_product_discount` WHERE product_id = $pro_id";
    include 'conn.php';
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
          
        return $row['discount'];
         
    } else {
        return  0;
    }
}
function acc_id(){
     include 'conn.php';
    $numargs = func_num_args();
    // $numargs == 3
    if ($numargs >= 2) {
//creation of query for each item with passing parameters
        $sql_max_price = "SELECT * FROM `tb_stock` s ";
        for ($x = 1; $x < $numargs; $x++) {
            $sql_max_price .= " LEFT JOIN tb_accessory_property ap$x on s.accessory_id = ap$x.accessory_id ";
        }
        $sql_max_price .= " WHERE s.accessory_type_id = " . func_get_arg(0) . " ";
        for ($x = 1; $x < $numargs; $x++) {
            $sql_max_price .= " AND ap$x.property_value_id = " . func_get_arg($x) . " ";
        }
        $sql_max_price .= " LIMIT 1";

        $result = $conn->query($sql_max_price);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['accessory_id'];
        } else {

            return 0;
            
        }
    } else {
        echo "invalid available accesory arguments";
    }
}