<?php

include 'helper.php';
include 'conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pro_id = $pro_qty = $d_address = $tp_no = $email = $d_comment = $product_cost = null;
    $pro_id = clean_input($_POST['pro_id']);
    $pro_qty = clean_input($_POST['pro_qty']);
    $d_comment = clean_input($_POST['d_comment']);
    $cus_name = clean_input($_POST['cus_name']);
    $d_address = clean_input($_POST['d_address']);
    $email = clean_input($_POST['email']);
    $tp_no = clean_input($_POST['tp_no']);
    date_default_timezone_set('UTC');
    $today = date("Ymd");

    //variable for error control
    $e = 1;
//empty validation--------------------------------------------------------------
    if (empty($pro_qty)) {
        echo"<div class='alert alert-danger'>Product quantity shoud not be empty</div>";
        $e = 0;
    } else {
        if ($pro_qty <= 0) {
            echo "<div class='alert alert-danger'>Product quantity invalid</div>";
            $e = 0;
        }
        if (!is_numeric($pro_qty)) {
            echo "<div class='alert alert-danger'>The product quantity should be number...!</div>";
            $e = 0;
        }
    }

    if (empty($d_comment)) {
        echo "<div class='alert alert-danger'>Design Comment shoud not be empty</div>";
        $e = 0;
    }

    if (empty($cus_name)) {
        echo "<div class='alert alert-danger'>Name shoud not be empty</div>";
        $e = 0;
    } else {
        if (!preg_match("/^[a-zA-Z ]*$/", $cus_name)) {
            echo "<div class='alert alert-danger'>Name is invalid...!</div>";
            $e = 0;
        }
    }

    if (empty($d_address)) {
        echo "<div class='alert alert-danger'>Delivery Address shoud not be empty</div>";
        $e = 0;
    }

    if (empty($email)) {
        echo "<div class='alert alert-danger'>Email address shoud not be empty</div>";
        $e = 0;
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<div class='alert alert-danger'>The Email address is invalid...!</div>";
            $e = 0;
        }
    }

    if (empty($tp_no)) {
        echo "<div class='alert alert-danger'>Telephone number shoud not be empty</div>";
        $e = 0;
    } else {
        if (!preg_match("/^[0-9+]*$/", $tp_no)) {
            echo "<div class='alert alert-danger'>The tlephone number is invalid...!</div>";
            $e = 0;
        }
    }


    //end empty validation------------------------------------------------------
    //select each product
    switch ($pro_id) {

//----------------------magazine------------------------------------------------
        case 1:
            //difine variable
            $cvr_ink_unit_price = $inr_ink_unit_price = $innr_ppr_qty = $ppr_size = $act_ppr_size = $ppr_thick = $ppr_colour = $inr_print = $pages = $print_side = $cvr_ppr_thick = $cvr_laminate = $binding = null;
            //assign values-----------------------------------------------------
            $ppr_size = clean_input($_POST['paper_size#1']);
            $ppr_thick = clean_input($_POST['paper_thick#7']);
            $ppr_color = clean_input($_POST['paper_colour#2']);
            if (isset($_POST['inner_print#20'])) {
                $inr_print = $_POST['inner_print#20'];
            }
            $pages = clean_input($_POST['pages#5']);
            if (isset($_POST['printing_side#12'])) {
                $print_side = $_POST['printing_side#12'];
            }
            $cvr_ppr_thick = clean_input($_POST['cover_paper_thick#8']);
            if (isset($_POST['cover_print#21'])) {
                $cvr_print = $_POST['cover_print#21'];
            }
            $cvr_laminate = clean_input($_POST['laminate_type#13']);
            $binding = clean_input($_POST['binding#10']);

            //end assign values-------------------------------------------------
            //empty validation-------------------------------------------------- 
            if (empty($ppr_size)) {
                echo "<div class='alert alert-danger'>Paper size shoud not be empty</div>";
                $e = 0;
            }
            if (empty($ppr_thick)) {
                echo "<div class='alert alert-danger'>Paper thick shoud not be empty</div>";
                $e = 0;
            }
            if (empty($ppr_color)) {
                echo "<div class='alert alert-danger'>Paper colour shoud not be empty</div>";
                $e = 0;
            }
            if (empty($inr_print)) {
                echo "<div class='alert alert-danger'>Inner Print shoud not be empty</div>";
                $e = 0;
            }
            if (empty($pages)) {
                echo "<div class='alert alert-danger'>Pages shoud not be empty</div>";
                $e = 0;
            }
            if (empty($print_side)) {
                echo "<div class='alert alert-danger'>Print Side shoud not be empty</div>";
                $e = 0;
            }
            if (empty($cvr_ppr_thick)) {
                echo "<div class='alert alert-danger'>Cover paper thick shoud not be empty</div>";
                $e = 0;
            }
            if (empty($cvr_print)) {
                echo "<div class='alert alert-danger'>Cover paper print type shoud not be empty</div>";
                $e = 0;
            }
            if (empty($cvr_laminate)) {
                echo "<div class='alert alert-danger'>Cover laminate type shoud not be empty</div>";
                $e = 0;
            }
            if (empty($binding)) {
                echo "<div class='alert alert-danger'>Binding type shoud not be empty</div>";
                $e = 0;
            }
            //end empty validation----------------------------------------------
            //  Advanced validation---------------------------------------------
            if ($pages <= 0) {
                echo "<div class='alert alert-danger'>The printable pages should be positive number...!</div>";
                $e = 0;
            }

//            end Advanced validation-------------------------------------------

            if ($e != 0) {
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','1','" . $ppr_size . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','7','" . $ppr_thick . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','2','" . $ppr_color . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','20','" . $inr_print . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','5','" . $pages . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','12','" . $print_side . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','8','" . $cvr_ppr_thick . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','21','" . $cvr_print . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','13','" . $cvr_laminate . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','10','" . $binding . "')";

// 1 inner paper cost-----------------------------------------------------------           
                //select exact paper for binding type
                //spiral binding 
                if ($binding == 14) {

                    if ($print_side == 8) {//single side
                        $innr_ppr_qty = $pages;
                    } elseif ($print_side == 9) {//double side
                        if ($pages % 2 == 0) {
                            $innr_ppr_qty = $pages / 2;
                        } else {
                            // floor() : Round numbers down to the nearest integer
                            $innr_ppr_qty = floor($pages / 2);
                            ++$innr_ppr_qty;
                        }
                    }
                    $act_ppr_size = $ppr_size;

                    // do not have cange for that 
                } elseif ($binding == 13 or $binding == 63) {  // perfect bind and sandlestich
                    // size should be double and pages should be half change for this binding type
                    //page size query for calculation    
                    $sql_page_size = "SELECT `value` FROM `tb_product_property_value` WHERE `property_value_id`= $ppr_size";
                    $result_ppr_size_val = $conn->query($sql_page_size);
                    $row_ppr_size = $result_ppr_size_val->fetch_assoc();
                    $row_ppr_size['value'];
                    $new_size = substr($row_ppr_size['value'], 1);
                    if ($new_size != 0) {
                        --$new_size;
                        $act_ppr_val = substr_replace($row_ppr_size['value'], $new_size, 1);
                        $sql = "SELECT property_value_id FROM `tb_product_property_value` WHERE `value` = '$act_ppr_val' ";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $act_ppr_size = $row['property_value_id'];
                    } else {
                        echo "<div class='alert alert-danger'>for book or magazine size shoud not be zero type</div>";
                        $e = 0;
                        break;
                    }
                    if ($print_side == 8) {//single side
                        if ($pages % 2 == 0) {
                            $innr_ppr_qty = $pages / 2;
                        } else {
                            // floor() : Round numbers down to the nearest integer
                            $innr_ppr_qty = floor($pages / 2);
                            ++$innr_ppr_qty;
                        }
                    } elseif ($print_side == 9) {//double side
                        if ($pages % 4 == 0) {
                            $innr_ppr_qty = $pages / 4;
                        } else {
                            // floor() : Round numbers down to the nearest integer
                            $innr_ppr_qty = floor($pages / 4);
                            ++$innr_ppr_qty;
                        }
                    }
                }
//Advanced validation---------------------------------------
                if (avlable_itm_max_price(1, $act_ppr_size, $ppr_thick, $ppr_color) == 0) {
                    $e = 0;
                    break;
                }
                $innr_ppr_cost = ($innr_ppr_qty * avlable_itm_max_price(1, $act_ppr_size, $ppr_thick, $ppr_color) * $pro_qty);
                $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(1, $act_ppr_size, $ppr_thick, $ppr_color) . "','" . $innr_ppr_qty * $pro_qty . "')";
//end inner paper cost----------------------------------------------------------
//cover paper width and length
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $act_ppr_size AND property_id = 22";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $cvr_width = $row['value'];

                    $sql = "SELECT * FROM `tb_product_property_value` WHERE property_id = 22 AND value = $cvr_width";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $cvr_width_id = $row['property_value_id'];
                    }
                }
                //23:length
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $act_ppr_size AND property_id = 23";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $cvr_length = $row['value'];
                }

//2 cover paper & thickness of bundle of sheets---------------------------------
                //Advanced validation---------------------------------------
                if (avlable_itm_max_price(8, $cvr_width_id, $cvr_ppr_thick) == 0) {
                    $e = 0;
                    break;
                }
                $board_unit = avlable_itm_max_price(8, $cvr_width_id, $cvr_ppr_thick);
                // inner paper bundle thick calculation
                $sql = "SELECT * FROM `tb_product_property_value`  
                        WHERE property_value_id = $ppr_thick";

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $innr_ppr_thick_val = $row['value'];
                }

                $innr_ppr_thick_val = explode(" ", $innr_ppr_thick_val);
                //thickness and waight calculation formula thickness = (gsm/1000) +0.2
                $unit_thick = (($innr_ppr_thick_val[0] / 1000) + 0.02);

                if ($binding == 14) {//comb 
                    $cvr_length += $cvr_length;
                } elseif ($binding == 13) {//perfect bind
                    // additional 2 for floding and multyply by 2 is while floding paper count become double
                    $cvr_length += (($innr_ppr_qty * $unit_thick) * 2) + 2;
                } elseif ($binding == 63) {// sandlestich
                    $cvr_length += 2;
                }
                $cvr_ppr_cost = $board_unit * $cvr_length * $pro_qty;
                $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(8, $cvr_width_id, $cvr_ppr_thick) . "','" . $cvr_length * $pro_qty . "')";
//end cover paper cost----------------------------------------------------------
// 3 inner ink cost calculation-------------------------------------------------
                $innr_color_type = $innr_print_type = null;

                if ($pro_qty < 500) {

                    $innr_print_type = 150; // digital print
                    $serface = 2.1; //count of ml per squre meter for digital print
                    if ($inr_print == 66) {// 1/1 black
                        // black
                        $innr_color_type = 46;
                        //                         is available in stock
                        if (avlable_itm_max_price(5, $innr_color_type, $innr_print_type) == 0) {
                            $e = 0;
                            break;
                        }
                        // price for black ink 
                        $inr_ink_unit_price = avlable_itm_max_price(5, $innr_color_type, $innr_print_type);
                    } elseif ($inr_print == 67) {// 4/4 cmyk
                        // price for all 4 colors 
                        for ($innr_color_type = 43; $innr_color_type <= 46; $innr_color_type++) {
                            //                         is available in stock
                            if (avlable_itm_max_price(5, $innr_color_type, $innr_print_type) == 0) {
                                $e = 0;
                                break;
                            }
                            $inr_ink_unit_price += avlable_itm_max_price(5, $innr_color_type, $innr_print_type);
                        }
                    }
                } else {
                    $innr_print_type = 149; // offset print
                    $serface = 0.9; //count of ml per squre meter foor offset print
                    if ($inr_print == 66) {// 1/1 black
                        $innr_color_type = 46;
//                         is available in stock
                        if (avlable_itm_max_price(5, $innr_color_type, $innr_print_type) == 0) {
                            $e = 0;
                            break;
                        }
                        // price for black ink 
                        echo "inner ink unit cost " . $inr_ink_unit_price = avlable_itm_max_price(5, $innr_color_type, $innr_print_type) . "                               ";
                        //
                    } elseif ($inr_print == 67) {// 4/4 cmyk
                        // price for all 4 colors 
                        for ($innr_color_type = 43; $innr_color_type <= 46; $innr_color_type++) {
                            //                         is available in stock
                            if (avlable_itm_max_price(5, $innr_color_type, $innr_print_type) == 0) {
                                $e = 0;
                                break;
                            }
                            "inner ink unit cost " . $inr_ink_unit_price += avlable_itm_max_price(5, $innr_color_type, $innr_print_type) . "                          ";
                        }
                    }
                }

                // width of inner printing serface area 
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $ppr_size AND property_id = 23";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $length = $row['value'];
                }
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $ppr_size AND property_id = 22";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $width = $row['value'];
                }

                $tot_area = $width * $length * $pages * $pro_qty; // total area for production

                $innr_ink_cost = ($tot_area * $serface * $inr_ink_unit_price ) / 1000000;  // total  inner ink cost
//            accsosory count sql
                if ($inr_print == 66) {//black
                    $innr_color_type = 46;
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $innr_color_type, $innr_print_type) . "','" . ($tot_area * $serface) / 1000000 . "')";
                } elseif ($inr_print == 67) {// 4/4 cmyk
                    // price for all 4 colors 
                    for ($innr_color_type = 43; $innr_color_type <= 46; $innr_color_type++) {

                        $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $innr_color_type, $innr_print_type) . "','" . ($tot_area * $serface) / 1000000 . "')";
                    }
                }
//end inner ink cost calculation------------------------------------------------
//4 cover print ink cost--------------------------------------------------------
                if ($pro_qty < 500) {
                    $cvr_print_type = 150; // digital print
                    $serface = 2.1; //count of ml per squre meter for digital print
                    if ($cvr_print == 65) {// 1/1 black                    
                        $cvr_color_type = 46; // black  
                        //is available in stock
                        if (avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type) == 0) {

                            break;
                        }
                        $cvr_ink_unit_price = avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type); // price for black ink 
                    } elseif ($cvr_print == 64) {// 4/4 cmyk
                        // price for all 4 colors 
                        for ($cvr_color_type = 43; $cvr_color_type <= 46; $cvr_color_type++) {
                            //is available in stock
                            if (avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type) == 0) {
                                break;
                            }
                            $cvr_ink_unit_price += avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                        }
                    }
                } else {
                    $cvr_print_type = 149; // offset print
                    $serface = 0.9; //count of ml per squre meter foor offset print
                    if ($cvr_print == 65) {// 1/1 black
                        $cvr_color_type = 46; //black
                        //is available in stock
                        if (avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type) == 0) {
                            $e = 0;
                            break;
                        }
                        // price for black ink 
                        $cvr_ink_unit_price = avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                    } elseif ($cvr_print == 64) {// 4/4 cmyk
                        // price for all 4 colors 
                        for ($cvr_color_type = 43; $cvr_color_type <= 46; $cvr_color_type++) {
                            //is available in stock
                            if (avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type) == 0) {
                                $e = 0;
                                break;
                            }

                            $cvr_ink_unit_price += avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                        }
                    }
                }
                // total cover ink cost
                $cvr_ink_cost = $cvr_width * $cvr_length * $cvr_ink_unit_price * $pro_qty * $serface / 1000000;




                if ($cvr_print == 65) {// 1/1 black
                    $cvr_color_type = 46; //black
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $cvr_color_type, $cvr_print_type) . "','" . (($cvr_width * $cvr_length * $pro_qty * $serface) / 1000000) . "')";
                } elseif ($cvr_print == 64) {// 4/4 cmyk
                    // price for all 4 colors 
                    for ($cvr_color_type = 43; $cvr_color_type <= 46; $cvr_color_type++) {
                        $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $cvr_color_type, $cvr_print_type) . "','" . (($cvr_width * $cvr_length * $pro_qty * $serface) / 1000000) . "')";
                    }
                }


//end cover print ink cost------------------------------------------------------
//5 laminte paper---------------------------------------------------------------

                if ($cvr_laminate != 6) {// not non laminate type
                    //is available in stock
                    if (avlable_itm_max_price(10, $cvr_width_id, $cvr_laminate) == 0) {
                        $e = 0;
                        break;
                    }
//                laminate  price 
                    $laminate_cost = $cvr_length * avlable_itm_max_price(10, $cvr_width_id, $cvr_laminate) * $pro_qty;

                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(10, $cvr_width_id, $cvr_laminate) . "','" . $cvr_length * $pro_qty . "')";
                } else {
                    $laminate_cost = 0;
                }
//            total laminate price
//end laminate paper cost-------------------------------------------------------
//6 binding material cost-------------------------------------------------------
                $bind_cost = null;
                $sheet_thick = $unit_thick * $innr_ppr_qty;
                $thick = $sheet_thick + 2;

                if ($binding == 14) {// comb bind
                    $sql = "SELECT * FROM `tb_product_property_value` where property_id = 26  AND value >= $thick
                        ORDER BY `tb_product_property_value`.`value`  ASC LIMIT 1";

                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $comp_diameter = $row['property_value_id'];
                    }
                    //is available in stock
                    if (avlable_itm_max_price(9, $comp_diameter, prop_val_to_id(($cvr_length / 2))) == 0) {
                        $e = 0;
                        break;
                    }
                    //comb bind price 
                    $bind_cost = avlable_itm_max_price(9, $comp_diameter, prop_val_to_id(($cvr_length / 2))) * $pro_qty;
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(9, $comp_diameter, prop_val_to_id(($cvr_length / 2))) . "','" . $pro_qty . "')";
                } elseif ($binding == 13) { //perfect bind 
                    if ($innr_ppr_qty % 8 == 0) {
                        $wool_count = $innr_ppr_qty / 8;
                    } else {
                        $wool_count = floor($innr_ppr_qty / 8) + 1;
                    }
                    $wool_mat = 159; //nylon
                    $wool_color = 143; // white
                    //is available in stock
                    if (avlable_itm_max_price(15, $wool_mat, $wool_color) == 0) {
                        $e = 0;
                        break;
                    }
                    $wool_cost = avlable_itm_max_price(15, $wool_mat, $wool_color) * $cvr_width * $pro_qty * $wool_count;
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(15, $wool_mat, $wool_color) . "','" . $cvr_width * $pro_qty * $wool_count . "')";
                    //is available in stock
                    if (avlable_itm_max_price(7, $cvr_width_id) == 0) {
                        $e = 0;
                        break;
                    }
                    $glue_stick_cost = avlable_itm_max_price(7, $cvr_width_id) * $thick * $pro_qty;
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(7, $cvr_width_id) . "','" . $thick * $pro_qty . "')";
                    $bind_cost = $glue_stick_cost + $wool_cost;
                } elseif ($binding == 63) {// sndlestich bind
                    $sql = "SELECT * FROM `tb_product_property_value` where property_id = 24 AND value >= $thick ORDER BY `tb_product_property_value`.`value` ASC LIMIT 1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $comp_diameter = $row['property_value_id'];
                    }
                    //is available in stock
                    if (avlable_itm_max_price(4, $comp_diameter) == 0) {
                        $e = 0;
                        break;
                    }
                    $bind_cost = avlable_itm_max_price(4, $comp_diameter) * 2 * $pro_qty;
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(4, $comp_diameter) . "','" . 2 * $pro_qty . "')";
                }

                $tot_material_cost = $innr_ppr_cost + $cvr_ppr_cost + $innr_ink_cost + $cvr_ink_cost + $laminate_cost + $bind_cost;
       




                // sales price of item 30% added to actual cost
                "Total Cost Of Inner Paper(" . pro_id_to_val($act_ppr_size) . " x " . $innr_ppr_qty . " Sheets  x Quantity of " . $pro_qty . ") : " . sales_material_cost($innr_ppr_cost) . "<br>";
                "Total Cost Cover Paper (Width " . $cvr_width . "(mm) x Length " . $cvr_length . "(mm) x Quantity of " . $pro_qty . ")  : " . $cvr_ppr_cost . "<br>";

                "Total Ink Cost For Inner Print ( Width " . $width . "(mm) x Length " . $length . "(mm) " . $pages . " pages x Quantity of " . $pro_qty . ") : " . sales_material_cost($innr_ink_cost) . "<br>";

                "Total Ink Cost For Cover Print (Width " . $cvr_width . "(mm) x Length " . $cvr_length . "(mm) x Quantity of " . $pro_qty . ") : " . sales_material_cost($cvr_ink_cost) . "<br>";

                "Total Cost Of Cover Laminate(" . $cvr_width . "(mm) x " . $cvr_length . "(mm) x Quantity of " . $pro_qty . ") : " . sales_material_cost($laminate_cost) . "<br>";

                $bind = null;
                $bind .= "Total Cost Of Binding Materials(";
                if ($binding == 14) {
                    $bind .= "Plastick Comb Width(mm) " . $cvr_length / 2 . " x Diameter(mm) " . pro_id_to_val($comp_diameter);
                } elseif ($binding == 13) {
                    $bind .= "Nylon White Colour Wool Length " . $wool_count * $cvr_width . "(mm) And ";
                    $bind .= "Glue stick $cvr_width_id (mm) x $thick (mm) ";
                } elseif ($binding == 63) {
                    $bind .= "Staple leg length " . pro_id_to_val($comp_diameter) . " (mm) x 2 ";
                }
                $bind .= "x Quantity of " . $pro_qty . ") : " . sales_material_cost($bind_cost) . "<br>";

                "Total Cost Of Materials : " . round(sales_material_cost($tot_material_cost), 2) . "<br>";

// service cost-----------------------------------------------------------------
//01 cover design---------------------------------------------------------------
                "task cost of designing :" . $design_cost = task_cost(7, $cvr_width * $cvr_length) . "<br>";

//02 typing---------------------------------------------------------------------
                "task cost of typing :" . $typing_cost = task_cost(6, $width * $length * $pages) . "<br>";
//03 cover print----------------------------------------------------------------

                if ($cvr_print_type == 150) {//digital
                    $cvr_print_cost = task_cost(13, $cvr_width * $cvr_length * $pro_qty);
                } elseif ($cvr_print_type == 149) {// offset
                    $cvr_print_cost = task_cost(1, $cvr_width * $cvr_length * $pro_qty);
                } else {
                    echo"<div class='alert alert-danger'>Cover Print type invalid</div>";
                }
                if ($cvr_print == 64) {// 4/4 cmyk
                    $cvr_print_cost = $cvr_print_cost * 4;
                }
                "task cost of cover print :" . $cvr_print_cost . "<br>";
//04 inner print----------------------------------------------------------------
                "inner print type " . $inr_print;
                if ($innr_print_type == 150) {//digital
                    $innr_print_cost = task_cost(13, $width * $length * $pro_qty * $pages);
                } elseif ($innr_print_type == 149) {// offset
                    $innr_print_cost = task_cost(1, $width * $length * $pro_qty * $pages);
                } else {
                    echo"<div class='alert alert-danger'>Cover Print type invalid</div>";
                }
                if ($inr_print == 67) {// 4/4 cmyk
                    $innr_print_cost = $innr_print_cost * 4;
                }
                "task cost of inner print :" . $innr_print_cost . "<br>";
//            echo"cover width :" . $cvr_width . " cover length :" . $cvr_length;
//05 cover laminate-------------------------------------------------------------
                "task cost of laminating :" . $laminating_cost = task_cost(5, $cvr_width * $cvr_length * $pro_qty) . "<br>";
//06 binding--------------------------------------------------------------------

                if ($binding == 14) { // comb bind
                    $binding_cost = task_cost(3, $pro_qty);
                } elseif ($binding == 13) { //perfect bind 
                    $binding_cost = task_cost(9, $wool_count * $pro_qty); //sewing cost
                    $binding_cost += task_cost(12, $pro_qty); //glue binding
                } elseif ($binding == 63) {// sndlestich bind
                    $binding_cost = task_cost(8, $pro_qty * 2);
                } else {
                    echo"<div class='alert alert-danger'>Cover Print type invalid</div>";
                }

                "task cost of Binding :" . $binding_cost . "<br>";
//07 die cutting----------------------------------------------------------------
                "task cost of Die cutting :" . $die_cutting_cost = task_cost(4, $pro_qty) . "<br>";
//end task cost-----------------------------------------------------------------
                // view quatation 
                $tot_service_cost = $design_cost + $typing_cost + $cvr_print_cost + $innr_print_cost + $laminating_cost + $binding_cost + $die_cutting_cost;
                $total_pro_cost = $tot_service_cost + sales_material_cost($tot_material_cost);
                //discount for the product
                    if (discount($pro_id) == 0) {
                        $final_cost = $total_pro_cost;
                        $discount = 0;
                    } else {
                        $discount = ($total_pro_cost * discount($pro_id))/ 100 ;
                        $final_cost = $total_pro_cost - $discount;
                    }
                    $adv_pay = $final_cost / 2;


                $quate_view = "
         <table class ='table table-striped text-white'  style='width:100%' align='left'>
         <tr>
    <td colspan='2'><div><h4> " . pro_name($pro_id) . " Quote </h4> <br></div> </td>
       
  </tr>
  <tr>
    <td>Inner Paper Cost   </td>
    <td> Rs. " . number_format(sales_material_cost($innr_ppr_cost), 2) . "</td>   
  </tr>
  <tr>
    <td>Cover Paper Cost</td>
    <td> Rs. " . number_format(sales_material_cost($cvr_ppr_cost), 2) . "</td>
  </tr>
  <tr>
    <td>Inner Ink Cost</td>
    <td> Rs. " . number_format(sales_material_cost($innr_ink_cost), 2) . "</td>   
  </tr>
  <tr>
    <td>Cover Ink Cost</td>
    <td> Rs. " . number_format(sales_material_cost($cvr_ink_cost), 2) . "</td>   
  </tr>
  <tr>
    <td>Cover Laminate Paper Cost </td>
    <td> Rs. " . number_format(sales_material_cost($laminate_cost), 2) . "</td>    
  </tr>
  <tr>
    <td>Binding Material Cost</td>
    <td> Rs. " . number_format(sales_material_cost($bind_cost), 2) . "</td>
  </tr>
  <tr>
    <td><h5>Total Material Cost</h5> </td>
    <td><h5> Rs. " . number_format(sales_material_cost($tot_material_cost), 2) . "</h5></td>
  </tr>
</table> <br> 
<table style='width:100%'  class = 'table table-striped text-white' >
  <tr>
    <td>Designing Cost</td>
    <td> Rs. " . number_format($design_cost, 2) . "</td>   
  </tr>
  <tr>
    <td>Typesetting Cost</td>
    <td> Rs. " . number_format($typing_cost, 2) . "</td>
  </tr>
  <tr>
    <td>Inner Printing Cost</td>
    <td> Rs. " . number_format($innr_print_cost, 2) . "</td>   
  </tr>
  <tr>
    <td>Cover Printing Cost</td>
    <td> Rs. " . number_format($cvr_print_cost, 2) . "</td>   
  </tr>
  <tr>
    <td>Cover Laminating Cost </td>
    <td> Rs. " . number_format($laminating_cost, 2) . "</td>    
  </tr>
  <tr>
    <td>Binding  Cost</td>
    <td> Rs. " . number_format($binding_cost, 2) . "</td>
  </tr>
  <tr>
    <td>Die Cutting Cost</td>
    <td> Rs. " . number_format($die_cutting_cost, 2) . "</td>
  </tr>
  <tr>
    <td><h5>Total Service Cost</h5> </td>
    <td><h5> Rs. " . number_format($tot_service_cost, 2) . "</h5> </td>
  </tr>
</table> <br>
 ";





                $quate_total = "<table style='width:100%' align='left' class = 'table table-striped text-white' > ";

                if (discount($pro_id) != 0) {
                    $quate_total .= " <tr>
                             <td><h5>Grand Total </h5></td>
                             <td><h5>Rs. " . number_format($tot_service_cost + sales_material_cost($tot_material_cost)) . " </h5></td>
                             </tr> 
                            <tr>
                            <td><h5> Discount of (" . discount($pro_id) . " %) </h5> </td><td><h5> Rs." . $discount . "</h5></td></tr>"
                            . " <tr><td><h5> Net Amount </h5> </td> <td><h5>  Rs." . $final_cost . " </h5></td></tr>";
                } else {
                    $quate_total .= "<tr>"
                            . "<td><h5> Net Amount </h5></td>"
                            . " <td><h5>  Rs." . $final_cost . " </h5></td>"
                            . "</tr>";
                }
                $quate_total .= "<tr>
    <td</td>
    <td></td>
  </tr>
  <tr>
    <td colspan='2' > To Conferm the order minimum advance payment is Rs. $adv_pay </td>
    
  </tr>
</table>";


                echo $quate_view;
                echo $quate_total;
            }
            break;
//-----------------------------Book---------------------------------------------
        case 2:
            // define variable 
            $cvr_ink_unit_price = $inr_ink_unit_price = $innr_ppr_qty = $ppr_size = $act_ppr_size = $ppr_thick = $ppr_color = $inr_print = $pages = $print_side = $cvr_ppr_thick = $cvr_laminate = $binding = null;
            //assign values-----------------------------------------------------
            $ppr_size = clean_input($_POST['paper_size#1']);
            $ppr_thick = clean_input($_POST['paper_thick#7']);
            $ppr_color = clean_input($_POST['paper_colour#2']);
            if (isset($_POST['inner_print#20'])) {
                $inr_print = $_POST['inner_print#20'];
            }

            $pages = clean_input($_POST['pages#5']);
            if (isset($_POST['printing_side#12'])) {
                $print_side = $_POST['printing_side#12'];
            }

            $cvr_ppr_thick = clean_input($_POST['cover_paper_thick#8']);
            if (isset($_POST['cover_print#21'])) {
                $cvr_print = $_POST['cover_print#21'];
            }

            $cvr_laminate = clean_input($_POST['laminate_type#13']);
            $binding = clean_input($_POST['binding#10']);
            //end assign values-------------------------------------------------
            //empty validation-------------------------------------------------- 
            if (empty($ppr_size)) {
                echo "<div class='alert alert-danger'>Paper size shoud not be empty</div>";
                $e = 0;
            }
            if (empty($ppr_thick)) {
                echo "<div class='alert alert-danger'>Paper thick shoud not be empty</div>";
                $e = 0;
            }
            if (empty($ppr_color)) {
                echo "<div class='alert alert-danger'>Paper colour shoud not be empty</div>";
                $e = 0;
            }
            if (empty($inr_print)) {
                echo "<div class='alert alert-danger'>Inner Print shoud not be empty</div>";
                $e = 0;
            }
            if (empty($pages)) {
                echo "<div class='alert alert-danger'>Pages shoud not be empty</div>";
                $e = 0;
            }
            if (empty($print_side)) {
                echo "<div class='alert alert-danger'>Print Side shoud not be empty</div>";
                $e = 0;
            }
            if (empty($cvr_ppr_thick)) {
                echo "<div class='alert alert-danger'>Cover paper thick shoud not be empty</div>";
                $e = 0;
            }
            if (empty($cvr_print)) {
                echo "<div class='alert alert-danger'>Cover paper print type shoud not be empty</div>";
                $e = 0;
            }
            if (empty($cvr_laminate)) {
                echo "<div class='alert alert-danger'>Cover laminate type shoud not be empty</div>";
                $e = 0;
            }
            if (empty($binding)) {
                echo "<div class='alert alert-danger'>Binding type shoud not be empty</div>";
                $e = 0;
            }
            //end empty validation----------------------------------------------
            if ($pages <= 0) {
                echo "<div class='alert alert-danger'>The printable pages should be positive number...!</div>";
                $e = 0;
            }

            //end empty validation----------------------------------------------
            if ($pages <= 0) {
                echo $x['pages'] = "<div class='alert alert-danger'>The printable pages should be positive number...!</div>";
                $e = 0;
            }
            if ($e != 0) {



                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','1','" . $ppr_size . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','7','" . $ppr_thick . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','2','" . $ppr_color . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','20','" . $inr_print . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','5','" . $pages . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','12','" . $print_side . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','8','" . $cvr_ppr_thick . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','21','" . $cvr_print . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','13','" . $cvr_laminate . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','10','" . $binding . "')";


                //end assign values-------------------------------------------------
                //empty validation-------------------------------------------------- 
                if (empty($pages)) {
                    echo $x['pages'] = "<div class='alert alert-danger'>Pages shoud not be empty</div>";
                    $e = 0;
                }
                //end empty validation----------------------------------------------
                if ($pages <= 0) {
                    echo $x['pages'] = "<div class='alert alert-danger'>The printable pages should be positive number...!</div>";
                    $e = 0;
                }
// 1 inner paper cost-----------------------------------------------------------           
                //select exact paper for binding type
                //spiral binding 
                if ($binding == 14) {

                    if ($print_side == 8) {//single side
                        $innr_ppr_qty = $pages;
                    } elseif ($print_side == 9) {//double side
                        if ($pages % 2 == 0) {
                            $innr_ppr_qty = $pages / 2;
                        } else {
                            // floor() : Round numbers down to the nearest integer
                            $innr_ppr_qty = floor($pages / 2);
                            ++$innr_ppr_qty;
                        }
                    }
                    $act_ppr_size = $ppr_size;
                } elseif ($binding == 13 or $binding == 63) {  // perfect bind and sandlestich
                    //page size query for calculation    
                    $sql_page_size = "SELECT `value` FROM `tb_product_property_value` WHERE `property_value_id`= $ppr_size";
                    $result_ppr_size_val = $conn->query($sql_page_size);
                    $row_ppr_size = $result_ppr_size_val->fetch_assoc();
                    $row_ppr_size['value'];
                    $new_size = substr($row_ppr_size['value'], 1);
                    if ($new_size != 0) {
                        --$new_size;
                        $act_ppr_val = substr_replace($row_ppr_size['value'], $new_size, 1);
                        $sql = "SELECT property_value_id FROM `tb_product_property_value` WHERE `value` = '$act_ppr_val' ";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $act_ppr_size = $row['property_value_id'];
                    } else {
                        echo "<div class='alert alert-danger'>for book or magazine size shoud not be zero type</div>";
                        break;
                    }
                    if ($print_side == 8) {//single side
                        if ($pages % 2 == 0) {
                            $innr_ppr_qty = $pages / 2;
                        } else {
                            // floor() : Round numbers down to the nearest integer
                            $innr_ppr_qty = floor($pages / 2);
                            ++$innr_ppr_qty;
                        }
                    } elseif ($print_side == 9) {//double side
                        if ($pages % 4 == 0) {
                            $innr_ppr_qty = $pages / 4;
                        } else {
                            // floor() : Round numbers down to the nearest integer
                            $innr_ppr_qty = floor($pages / 4);
                            ++$innr_ppr_qty;
                        }
                    }
                    // size should be double and pages should be half change for this binding type
                }
                // inner paper cost
                //is available in stock
                if (avlable_itm_max_price(1, $act_ppr_size, $ppr_thick, $ppr_color) == 0) {
                    $e = 0;
                    break;
                }
                $innr_ppr_cost = ($innr_ppr_qty * avlable_itm_max_price(1, $act_ppr_size, $ppr_thick, $ppr_color) * $pro_qty);
                $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(1, $act_ppr_size, $ppr_thick, $ppr_color) . "','" . $innr_ppr_qty * $pro_qty . "')";
//end inner paper cost----------------------------------------------------------
                //cover paper width (22)
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $act_ppr_size AND property_id = 22";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $cvr_width = $row['value'];

                    $sql = "SELECT * FROM `tb_product_property_value` WHERE property_id = 22 AND value = $cvr_width";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $cvr_width_id = $row['property_value_id'];
                    }
                }
                // cover paper length(23)
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $act_ppr_size AND property_id = 23";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $cvr_length = $row['value'];
                }

//2 cover paper-----------------------------------------------------------------
                //is available in stock
                if (avlable_itm_max_price(8, $cvr_width_id, $cvr_ppr_thick) == 0) {
                    $e = 0;
                    break;
                }
                $board_unit = avlable_itm_max_price(8, $cvr_width_id, $cvr_ppr_thick);
                // inner paper thick calculation
                $sql = "SELECT * FROM `tb_product_property_value`  
                        WHERE property_value_id = $ppr_thick";

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $innr_ppr_thick_val = $row['value'];
                }

                $innr_ppr_thick_val = explode(" ", $innr_ppr_thick_val);
                //thickness and waight calculation formula thickness = (gsm/1000) +0.2
                $unit_thick = (($innr_ppr_thick_val[0] / 1000) + 0.02);

                if ($binding == 14) {//comb 
                    $cvr_length += $cvr_length;
                } elseif ($binding == 13) {//perfect bind
                    // additional 2 for floding and multyply by 2 is while floding paper count become double
                    $cvr_length += (($innr_ppr_qty * $unit_thick) * 2) + 2;
                } elseif ($binding == 63) {// sandlestich
                    $cvr_length += 2;
                }
                //  total board price 
                $cvr_ppr_cost = $board_unit * $cvr_length * $pro_qty;
                $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(8, $cvr_width_id, $cvr_ppr_thick) . "','" . $cvr_length * $pro_qty . "')";
//end cover paper cost----------------------------------------------------------
// 3 inner ink cost calculation-------------------------------------------------
                $innr_color_type = $innr_print_type = null;

                if ($pro_qty < 500) {
                    $innr_print_type = 150; // digital print
                    $serface = 2.1; //count of ml per squre meter for digital print
                    if ($inr_print == 66) {// 1/1 black
                        // black
                        $innr_color_type = 46;
                        //is available in stock
                        if (avlable_itm_max_price(5, $innr_color_type, $innr_print_type) == 0) {
                            $e = 0;
                            break;
                        }
                        // price for black ink 
                        $inr_ink_unit_price = avlable_itm_max_price(5, $innr_color_type, $innr_print_type);
                    } elseif ($inr_print == 67) {// 4/4 cmyk
                        // price for all 4 colors 
                        for ($innr_color_type = 43; $innr_color_type <= 46; $innr_color_type++) {
                            //is available in stock
                            if (avlable_itm_max_price(5, $innr_color_type, $innr_print_type) == 0) {
                                $e = 0;
                                break;
                            }
                            $inr_ink_unit_price += avlable_itm_max_price(5, $innr_color_type, $innr_print_type);
                        }
                    }
                } else {
                    $innr_print_type = 149; // offset print
                    $serface = 0.9; //count of ml per squre meter foor offset print
                    if ($inr_print == 66) {// 1/1 black
                        $innr_color_type = 46;
                        //is available in stock
                        if (avlable_itm_max_price(5, $innr_color_type, $innr_print_type) == 0) {
                            $e = 0;
                            break;
                        }
                        // price for black ink 
                        $inr_ink_unit_price = avlable_itm_max_price(5, $innr_color_type, $innr_print_type);
                        //
                    } elseif ($inr_print == 67) {// 4/4 cmyk
                        // price for all 4 colors 
                        for ($innr_color_type = 43; $innr_color_type <= 46; $innr_color_type++) {
                            //is available in stock
                            if (avlable_itm_max_price(5, $innr_color_type, $innr_print_type) == 0) {
                                $e = 0;
                                break;
                            }
                            $inr_ink_unit_price += avlable_itm_max_price(5, $innr_color_type, $innr_print_type);
                        }
                    }
                }

                // width of inner printing serface area 
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $ppr_size AND property_id = 23";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $length = $row['value'];
                }
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $ppr_size AND property_id = 22";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $width = $row['value'];
                }
                //  total area for production 
                $tot_area = $width * $length * $pages * $pro_qty;
                // total  inner ink cost
                $innr_ink_cost = ($tot_area * $serface * $inr_ink_unit_price ) / 1000000;




                if ($inr_print == 66) {//black
                    $innr_color_type = 46;
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $innr_color_type, $innr_print_type) . "','" . ($tot_area * $serface) / 1000000 . "')";
                } elseif ($inr_print == 67) {// 4/4 cmyk
                    // price for all 4 colors 
                    for ($innr_color_type = 43; $innr_color_type <= 46; $innr_color_type++) {
                        $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $innr_color_type, $innr_print_type) . "','" . ($tot_area * $serface) / 1000000 . "')";
                    }
                }

//end inner ink cost calculation------------------------------------------------
//4 cover print ink cost--------------------------------------------------------
                if ($pro_qty < 500) {
                    $cvr_print_type = 150; // digital print
                    $serface = 2.1; //count of ml per squre meter for digital print
                    if ($cvr_print == 65) {// 1/1 black
                        $cvr_color_type = 46; // black
                        //is available in stock
                        if (avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type) == 0) {
                            $e = 0;
                            break;
                        }
                        // price for black ink 
                        $cvr_ink_unit_price = avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                    } elseif ($cvr_print == 64) {// 4/4 cmyk
                        // price for all 4 colors 
                        for ($cvr_color_type = 43; $cvr_color_type <= 46; $cvr_color_type++) {
                            //is available in stock
                            if (avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type) == 0) {
                                $e = 0;
                                break;
                            }
                            $cvr_ink_unit_price += avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                        }
                    }
                } else {
                    $cvr_print_type = 149; // offset print
                    $serface = 0.9; //count of ml per squre meter foor offset print
                    if ($cvr_print == 66) {// 1/1 black
                        $cvr_color_type = 46;
                        //is available in stock
                        if (avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type) == 0) {
                            $e = 0;
                            break;
                        }
                        // price for black ink 
                        $cvr_ink_unit_price = avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                    } elseif ($cvr_print == 67) {// 4/4 cmyk
                        // price for all 4 colors 
                        for ($cvr_color_type = 43; $cvr_color_type <= 46; $cvr_color_type++) {
                            //is available in stock
                            if (avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type) == 0) {
                                $e = 0;
                                break;
                            }
                            $cvr_ink_unit_price += avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                        }
                    }
                }
                //total cover ink cost
                $cvr_ink_cost = $cvr_width * $cvr_length * $pro_qty * $serface * $cvr_ink_unit_price / 1000000;


                if ($cvr_print == 65) {// 1/1 black
                    $cvr_color_type = 46; //black
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $cvr_color_type, $cvr_print_type) . "','" . (($cvr_width * $cvr_length * $pro_qty * $serface) / 1000000) . "')";
                } elseif ($cvr_print == 64) {// 4/4 cmyk
                    // price for all 4 colors 
                    for ($cvr_color_type = 43; $cvr_color_type <= 46; $cvr_color_type++) {
                        $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $cvr_color_type, $cvr_print_type) . "','" . (($cvr_width * $cvr_length * $pro_qty * $serface) / 1000000) . "')";
                    }
                }

//end cover print ink cost------------------------------------------------------
//5 laminte paper---------------------------------------------------------------

                if ($cvr_laminate != 6) {// not non laminate type
                    //is available in stock
                    if (avlable_itm_max_price(10, $cvr_width_id, $cvr_laminate) == 0) {
                        $e = 0;
                        break;
                    }
                    // laminate  price formula
                    $laminate_cost = $cvr_length * avlable_itm_max_price(10, $cvr_width_id, $cvr_laminate) * $pro_qty;
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(10, $cvr_width_id, $cvr_laminate) . "','" . $cvr_length * $pro_qty . "')";
                } else {
                    $laminate_cost = 0;
                }

//end laminate paper cost-------------------------------------------------------
//6 binding cost----------------------------------------------------------------
                $bind_cost = null;
                $sheet_thick = $unit_thick * $innr_ppr_qty;
                $thick = $sheet_thick + 2;

                if ($binding == 14) {// comb bind
                    $sql = "SELECT * FROM `tb_product_property_value` where property_id = 26  AND value >= $thick
                        ORDER BY `tb_product_property_value`.`value`  ASC LIMIT 1";

                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $comp_diameter = $row['property_value_id'];
                    }
                    //is available in stock
                    if (avlable_itm_max_price(9, $comp_diameter, prop_val_to_id(($cvr_length / 2))) == 0) {
                        $e = 0;
                        break;
                    }
                    //comb bind price 
                    $bind_cost = avlable_itm_max_price(9, $comp_diameter, prop_val_to_id(($cvr_length / 2))) * $pro_qty;
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(9, $comp_diameter, prop_val_to_id(($cvr_length / 2))) . "','" . $pro_qty . "')";
                } elseif ($binding == 13) { //perfect bind 
                    if ($innr_ppr_qty % 8 == 0) {
                        $wool_count = $innr_ppr_qty / 8;
                    } else {
                        $wool_count = floor($innr_ppr_qty / 8) + 1;
                    }
                    $wool_mat = 159; //nylon
                    $wool_color = 143; // white
//is available in stock
                    if (avlable_itm_max_price(15, $wool_mat, $wool_color) == 0) {
                        $e = 0;
                        break;
                    }
                    $wool_cost = avlable_itm_max_price(15, $wool_mat, $wool_color) * $cvr_width * $pro_qty * $wool_count;
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(15, $wool_mat, $wool_color) . "','" . $cvr_width * $pro_qty * $wool_count . "')";
                    //is available in stock
                    if (avlable_itm_max_price(7, $cvr_width_id) == 0) {
                        $e = 0;
                        break;
                    }
                    $glue_stick_cost = avlable_itm_max_price(7, $cvr_width_id) * $thick * $pro_qty;
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(7, $cvr_width_id) . "','" . $thick * $pro_qty . "')";
                    $bind_cost = $glue_stick_cost + $wool_cost;
                } elseif ($binding == 63) {// sndlestich bind
                    $sql = "SELECT * FROM `tb_product_property_value` where property_id = 24 AND value >= $thick ORDER BY `tb_product_property_value`.`value` ASC LIMIT 1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {

                        $row = $result->fetch_assoc();
                        $comp_diameter = $row['property_value_id'];
                    }
                    //is available in stock
                    if (avlable_itm_max_price(4, $comp_diameter) == 0) {
                        $e = 0;
                        break;
                    }
                    $bind_cost = avlable_itm_max_price(4, $comp_diameter) * 2 * $pro_qty;
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(4, $comp_diameter) . "','" . 2 * $pro_qty . "')";
                }
//end binding cost--------------------------------------------------------------
//Total Cost of material--------------------------------------------------------
                //total material cost 
                $tot_material_cost = $innr_ppr_cost + $cvr_ppr_cost + $innr_ink_cost + $cvr_ink_cost + $laminate_cost + $bind_cost;
                // sales price of item 30% added to actual cost
                "Total Cost Of Inner Paper(" . pro_id_to_val($act_ppr_size) . " x " . $innr_ppr_qty . " Sheets  x Quantity of " . $pro_qty . ") : " . sales_material_cost($innr_ppr_cost);

                "<br> Total Cover Paper (Width " . $cvr_width . "(mm) x Length " . $cvr_length . "(mm) x Quantity of " . $pro_qty . ")  : " . sales_material_cost($cvr_ppr_cost);

                "Total Ink Cost For Inner Print ( Width " . $width . "(mm) x Length " . $length . "(mm) " . $pages . " pages x Quantity of " . $pro_qty . ") : " . sales_material_cost($innr_ink_cost);

                "Total Ink Cost For Cover Print (Width " . $cvr_width . "(mm) x Length " . $cvr_length . "(mm) x Quantity of " . $pro_qty . ") : " . sales_material_cost($cvr_ink_cost);

                "Total Cost Of Cover Laminate(" . $cvr_width . "(mm) x " . $cvr_length . "(mm) x Quantity of " . $pro_qty . ") : " . sales_material_cost($laminate_cost);

                $bind = null;
                $bind .= "Total Cost Of Binding Materials(";
                if ($binding == 14) {
                    $bind .= "Plastick Comb Width(mm) " . ($cvr_length / 2) . "  x Diameter(mm) " . pro_id_to_val($comp_diameter);
                } elseif ($binding == 13) {
                    $bind .= "Nylon White Colour Wool Length " . $wool_count * $cvr_width . "(mm) And ";
                    $bind .= "Glue stick $cvr_width_id (mm) x $thick (mm) ";
                } elseif ($binding == 63) {
                    $bind .= "Staple leg length " . pro_id_to_val($comp_diameter) . " (mm) x 2 ";
                }
                $bind .= " Quantity of " . $pro_qty . ") : " . sales_material_cost($bind_cost);

                "Total Cost Of Materials : " . round(sales_material_cost($tot_material_cost), 2);
//end total material cost-------------------------------------------------------
// service cost--------------------------------------------------------------------
//01 cover design---------------------------------------------------------------
                "task cost of designing :" . $design_cost = task_cost(7, $cvr_width * $cvr_length);
//02 typing---------------------------------------------------------------------
                "task cost of typing :" . $typing_cost = task_cost(6, $width * $length * $pages);
//03 cover print----------------------------------------------------------------


                if ($cvr_print_type == 150) {//digital
                    $cvr_print_cost = task_cost(13, $cvr_width * $cvr_length * $pro_qty);
                } elseif ($cvr_print_type == 149) {// offset
                    $cvr_print_cost = task_cost(1, $cvr_width * $cvr_length * $pro_qty);
                } else {
                    "<div class='alert alert-danger'>Cover Print type invalid</div>";
                }
                if ($cvr_print == 64) {// 4/4 cmyk
                    $cvr_print_cost = $cvr_print_cost * 4;
                }
                "task cost of cover print :" . $cvr_print_cost;
//04 inner print----------------------------------------------------------------
                "inner print type " . $inr_print;
                if ($innr_print_type == 150) {//digital
                    $innr_print_cost = task_cost(13, $width * $length * $pro_qty * $pages);
                } elseif ($innr_print_type == 149) {// offset
                    $innr_print_cost = task_cost(1, $width * $length * $pro_qty * $pages);
                } else {
                    echo"<div class='alert alert-danger'>Cover Print type invalid</div>";
                }
                if ($inr_print == 67) {// 4/4 cmyk
                    $innr_print_cost = $innr_print_cost * 4;
                }
                "task cost of inner print :" . $innr_print_cost;
//            "cover width :" . $cvr_width . " cover length :" . $cvr_length;
//05 cover laminating-------------------------------------------------------------
                if ($cvr_laminate != 6) {// not non laminate type
                    $laminating_cost = task_cost(5, $cvr_width * $cvr_length * $pro_qty);
                } else {
                    $laminating_cost = 0;
                }
//06 binding--------------------------------------------------------------------

                if ($binding == 14) { // comb bind
                    $binding_cost = task_cost(3, $pro_qty);
                } elseif ($binding == 13) { //perfect bind 
                    $binding_cost = task_cost(9, $wool_count * $pro_qty); //sewing cost
                    $binding_cost += task_cost(12, $pro_qty); //glue binding
                } elseif ($binding == 63) {// sndlestich bind
                    $binding_cost = task_cost(8, $pro_qty * 2);
                } else {
                    echo"<div class='alert alert-danger'>Cover Print type invalid</div>";
                }

                $binding_cost;
//07 die cutting----------------------------------------------------------------
                $die_cutting_cost = task_cost(4, $pro_qty);


                $tot_service_cost = $design_cost + $typing_cost + $cvr_print_cost + $innr_print_cost + $laminating_cost + $binding_cost;
                "Total Cost Of Service : " . round($tot_service_cost, 2);
                 $total_pro_cost = $tot_service_cost + sales_material_cost($tot_material_cost);
//                "Total Production cost : " . $total_pro_cost = (round($tot_service_cost, 2) + round(sales_material_cost($tot_material_cost), 2));
//            "cover paper cost " . sales_material_cost($laminate_cost + $cvr_ppr_cost + $cvr_ink_cost);
//            "print " . $cvr_print_cost;
//            "laminate " . $laminating_cost;
//            
//            
//            
//end task cost-----------------------------------------------------------------
                //discount for the product
                    if (discount($pro_id) == 0) {
                        $final_cost = $total_pro_cost;
                        $discount = 0;
                    } else {
                        $discount = ($total_pro_cost * discount($pro_id))/ 100 ;
                        $final_cost = $total_pro_cost - $discount;
                    }
                    $adv_pay = $final_cost / 2;


                $quate_view = "
         <table style='width:100%' align='left' class ='table table-striped text-white'>
         <tr>
    <td colspan='2'><div><h4> " . pro_name($pro_id) . " Quote </h4> <br></div> </td>
       
  </tr>
  <tr>
    <td>Inner Paper Cost   </td>
    <td> Rs. " . sales_material_cost($innr_ppr_cost) . "</td>   
  </tr>
  <tr>
    <td>Cover Paper Cost</td>
    <td> Rs. " . sales_material_cost($cvr_ppr_cost) . "</td>
  </tr>
  <tr>
    <td>Inner Ink Cost</td>
    <td> Rs. " . sales_material_cost($innr_ink_cost) . "</td>   
  </tr>
  <tr>
    <td>Cover Ink Cost</td>
    <td> Rs. " . sales_material_cost($cvr_ink_cost) . "</td>   
  </tr>
  <tr>
    <td>Cover Laminate Paper Cost </td>
    <td> Rs. " . sales_material_cost($laminate_cost) . "</td>    
  </tr>
  <tr>
    <td>Binding Material Cost</td>
    <td> Rs. " . sales_material_cost($bind_cost) . "</td>
  </tr>
  <tr>
    <td><h5>Total Material Cost</h5> </td>
    <td><h5> Rs. " . sales_material_cost($tot_material_cost) . "</h5></td>
  </tr>
</table> <br> 
<table style='width:100%' class ='table table-striped text-white'>
  <tr>
    <td>Designing Cost</td>
    <td> Rs. " . number_format($design_cost, 2) . "</td>   
  </tr>
  <tr>
    <td>Typesetting Cost</td>
    <td> Rs. " . number_format($typing_cost, 2) . "</td>
  </tr>
  <tr>
    <td>Inner Printing Cost</td>
    <td> Rs. " . number_format($innr_print_cost, 2) . "</td>   
  </tr>
  <tr>
    <td>Cover Printing Cost</td>
    <td> Rs. " . number_format($cvr_print_cost, 2) . "</td>   
  </tr>
  <tr>
    <td>Cover Laminating Cost </td>
    <td> Rs. " . number_format($laminating_cost, 2) . "</td>    
  </tr>
  <tr>
    <td>Binding  Cost</td>
    <td> Rs. " . number_format($binding_cost, 2) . "</td>
  </tr>
  <tr>
  <tr>
    <td>Die Cutting Cost</td>
    <td> Rs. " . number_format($die_cutting_cost, 2) . "</td>
  </tr>
  <tr>
    <td><h5>Total Service Cost</h5> </td>
    <td><h5> Rs. " . number_format($tot_service_cost, 2) . "</h5> </td>
  </tr>
</table> <br>
 ";





                $quate_total = "<table style='width:100%' align='left'  class ='table table-striped text-white'> ";

                if (discount($pro_id) != 0) {
                    $quate_total .= " <tr>
                             <td><h5>Grand Total </h5></td>
                             <td><h5>Rs. " . number_format($tot_service_cost + sales_material_cost($tot_material_cost), 2) . " </h5></td>
                             </tr> 
                            <tr>
                            <td><h5> Discount of (" . discount($pro_id) . " %) </h5> </td><td><h5> Rs." . number_format($discount, 2) . "</h5></td></tr>"
                            . "     <tr><td><h5> Net Amount </h5> </td> <td><h5>  Rs." . number_format($final_cost, 2) . "</h5></td></tr>";
                } else {
                    $quate_total .= "<tr><td><h5> Net Amount </h5></td> <td><h5>  Rs. " . number_format($final_cost, 2) . "</h5></td></tr>";
                }" ";
                $quate_total .= "<tr>
    <td</td>
    <td></td>
  </tr>
  <tr>
    <td colspan='2' > To Conferm the order minimum advance payment is Rs. " . number_format($adv_pay, 2) . "</td>
    
  </tr>
</table>";


                echo $quate_view;
                echo $quate_total;
            }
            break;
//-------------------------poster-----------------------------------------------
        case 3:
            //define variable
            $ppr_size = $ppr_color = $ppr_thick = $ink_unit_price = $print = $laminate = $ppr_cost = $print_type = $ink_cost = $length = $width = $serface = $width_id = null;
            //Asign value
            $ppr_size = clean_input($_POST['paper_size#1']);
            $ppr_thick = clean_input($_POST['paper_thick#7']);
            $ppr_color = clean_input($_POST['paper_colour#2']);
            if (isset($_POST['print#37'])) {
                $print = $_POST['print#37'];
            }
            $laminate = clean_input($_POST['laminate_type#13']);
            $print_type = 149; //offset print
            $serface = 0.9; // offset serface of print
            //empty validation-------------------------------------------------- 
            if (empty($ppr_size)) {
                echo "<div class='alert alert-danger'>Paper size shoud not be empty</div>";
                $e = 0;
            }
            if (empty($ppr_thick)) {
                echo "<div class='alert alert-danger'>Paper thick shoud not be empty</div>";
                $e = 0;
            }
            if (empty($ppr_color)) {
                echo "<div class='alert alert-danger'>Paper colour shoud not be empty</div>";
                $e = 0;
            }
            if (empty($print)) {
                echo "<div class='alert alert-danger'>Print type shoud not be empty</div>";
                $e = 0;
            }
            if (empty($laminate)) {
                echo "<div class='alert alert-danger'>Laminate type shoud not be empty</div>";
                $e = 0;
            }

            //end empty validation----------------------------------------------

            if ($e != 0) {

                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','1','" . $ppr_size . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','7','" . $ppr_thick . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','2','" . $ppr_color . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','37','" . $print . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','13','" . $laminate . "')";


//1 paper----------------------------------------------------------------------- 
// //is available in stock
                if (avlable_itm_max_price(1, $ppr_size, $ppr_thick, $ppr_color) == 0) {
                    $e = 0;
                    break;
                }
                //paper cost

                $ppr_cost = ( avlable_itm_max_price(1, $ppr_size, $ppr_thick, $ppr_color) * $pro_qty);
                $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(1, $ppr_size, $ppr_thick, $ppr_color) . "','" . $pro_qty . "')";
//end paper---------------------------------------------------------------------
//2 ink ------------------------------------------------------------------------
                if ($print == 161) {// color 1/1 black
                    $color_type = 46; // black
                    if (avlable_itm_max_price(5, $color_type, $print_type) == 0) {
                        $e = 0;
                        break;
                    }
                    $ink_unit_price = avlable_itm_max_price(5, $color_type, $print_type);
                } elseif ($print == 162) {//color 4/4 cmyk
                    // price for all 4 colors 
                    for ($color_type = 43; $color_type <= 46; $color_type++) {
                        if (avlable_itm_max_price(5, $color_type, $print_type) == 0) {
                            $e = 0;
                            break;
                        }
                        $ink_unit_price += avlable_itm_max_price(5, $color_type, $print_type);
                    }
                }

                // width and length for printing serface area 
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $ppr_size AND property_id = 23";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $length = $row['value'];
                }
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $ppr_size AND property_id = 22";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $width = $row['value'];
                }

                $ink_cost = $ink_unit_price * $pro_qty * $length * $width * $serface / 1000000;

                if ($cvr_print == 65) {// 1/1 black
                    $cvr_color_type = 46; //black
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $color_type, $print_type) . "','" . (( $pro_qty * $length * $width * $serface ) / 1000000) . "')";
                } elseif ($cvr_print == 64) {// 4/4 cmyk
                    // price for all 4 colors 
                    for ($cvr_color_type = 43; $cvr_color_type <= 46; $cvr_color_type++) {
                        $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $color_type, $print_type) . "','" . (( $pro_qty * $length * $width * $serface ) / 1000000) . "')";
                    }
                }

//end ink-----------------------------------------------------------------------
//laminate----------------------------------------------------------------------
                if ($laminate != 6) {
                    $sql = "SELECT `property_value_id` FROM `tb_product_property_value` WHERE  value = $width AND property_id = 22";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $width_id = $row['property_value_id'];
                    }

                    //is available in stock 
                    if (avlable_itm_max_price(10, $width_id, $laminate) == 0) {
                        $e = 0;
                        break;
                    }
                    $laminate_cost = avlable_itm_max_price(10, $width_id, $laminate) * $pro_qty * $length;

                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(10, $width_id, $laminate) . "','" . ($pro_qty * $length) . "')";
                } else {
                    $laminate_cost = 0;
                }


//end laminate------------------------------------------------------------------
//total quate for meterials-----------------------------------------------------
                $tot_material_cost = $ink_cost + $ppr_cost + $laminate_cost;
                // sales price of item 30% added to actual cost
                "Total Cost Of Paper(" . pro_id_to_val($ppr_size) . " x " . $pro_qty . " Sheets  ) : " . sales_material_cost($ppr_cost);

                "Total Ink Cost For Print ( Width " . $width . "(mm) x Length " . $length . "(mm)  Quantity of " . $pro_qty . ") : " . sales_material_cost($ink_cost);

                "Total Cost Of  Laminate (" . $width . "(mm) x " . $length . "(mm) x Quantity of " . $pro_qty . ") : " . sales_material_cost($laminate_cost);

                "Total Cost Of Materials : " . round(sales_material_cost($tot_material_cost), 2);

// service cost-----------------------------------------------------------------
//01 design---------------------------------------------------------------------
                "task cost of designing :" . $design_cost = task_cost(7, $width * $length);
//02 printing-------------------------------------------------------------------
                $print_cost = task_cost(1, $width * $length * $pro_qty);
                if ($print == 162) {// color 4/4  cmyk
                    $print_cost = $print_cost * 4;
                }
//03 laminating-----------------------------------------------------------------
                if ($laminate != 6) {// not non laminate type
                    $laminating_cost = task_cost(5, $width * $length * $pro_qty);
                } else {
                    $laminating_cost = 0;
                }
                "task cost of laminating :" . $laminating_cost;
//04 diecutting-----------------------------------------------------------------
                if ($pro_qty % 50 == 0) {
                    $die_cutting_cost = task_cost(4, $pro_qty / 50);
                } else {
                    $die_cutting_cost = task_cost(4, floor($pro_qty / 50) + 1);
                }
                "task cost of die cutting :" . $die_cutting_cost;
// Total service cost ----------------------------------------------------------           
                $tot_service_cost = $design_cost + $print_cost + $laminating_cost + $die_cutting_cost;
                "Total Cost Of Service : " . round($tot_service_cost, 2);
//total production cost---------------------------------------------------------
                $total_pro_cost = $tot_service_cost + sales_material_cost($tot_material_cost);





//discount for the product
                    if (discount($pro_id) == 0) {
                        $final_cost = $total_pro_cost;
                        $discount = 0;
                    } else {
                        $discount = ($total_pro_cost * discount($pro_id))/ 100 ;
                        $final_cost = $total_pro_cost - $discount;
                    }
                    $adv_pay = $final_cost / 2;

                $quate_view = "
         <table style='width:100%' align='left' class ='table table-striped text-white'>
         <tr>
    <td colspan='2'><div><h4> " . pro_name($pro_id) . " Quote </h4> <br></div> </td>
       
  </tr>
  <tr>
    <td>Inner Paper Cost   </td>
    <td> Rs. " . number_format(sales_material_cost($ppr_cost)) . "</td>   
  </tr>
  
  <tr>
    <td>Ink Cost</td>
    <td> Rs. " . number_format(sales_material_cost($ink_cost)) . "</td>   
  </tr>
 
  <tr>
    <td>Laminate Paper Cost </td>
    <td> Rs. " . number_format(sales_material_cost($laminate_cost)) . "</td>    
  </tr>
  <tr>
    <td><h5>Total Material Cost</h5> </td>
    <td><h5> Rs. " . number_format(sales_material_cost($tot_material_cost), 2) . "</h5></td>
  </tr>
</table> <br> 
<table style='width:100%' class ='table table-striped text-white'>
  <tr>
    <td>Designing Cost</td>
    <td> Rs. " . number_format($design_cost, 2) . "</td>   
  </tr>
  
  <tr>
    <td>Printing Cost</td>
    <td> Rs. " . number_format($print_cost, 2) . "</td>   
  </tr>
  <tr>
    
  <tr>
    <td>Cover Laminating Cost </td>
    <td> Rs. " . number_format($laminating_cost, 2) . "</td>    
  </tr>
  
  <tr>
    <td>Die Cutting Cost</td>
    <td> Rs. " . number_format($die_cutting_cost, 2) . "</td>
  </tr>
  <tr>
    <td><h5>Total Service Cost</h5> </td>
    <td><h5> Rs. " . number_format($tot_service_cost, 2) . "</h5> </td>
  </tr>
</table> <br>
 ";





                $quate_total = "<table style='width:100%' align='left' class ='table table-striped text-white' > ";

                if (discount($pro_id) != 0) {
                    $quate_total .= " <tr>
                             <td><h5>Grand Total </h5></td>
                             <td><h5>Rs. " . number_format($tot_service_cost + sales_material_cost($tot_material_cost), 2) . " </h5></td>
                             </tr> 
                            <tr>
                            <td><h5> Discount of (" . discount($pro_id) . " %) </h5> </td><td><h5> Rs." . number_format($discount, 2) . "</h5></td></tr>"
                            . "     <tr><td><h5> Net Amount </h5> </td> <td><h5>  Rs." . number_format($final_cost, 2) . "</h5></td></tr>";
                } else {
                    $quate_total .= "<tr><td><h5> Net Amount </h5></td> <td><h5>  Rs. " . number_format($final_cost, 2) . "</h5></td></tr>";
                }" ";
                $quate_total .= "<tr>
    <td</td>
    <td></td>
  </tr>
  <tr>
    <td colspan='2' > To Conferm the order minimum advance payment is Rs. " . number_format($adv_pay, 2) . " </td>
    
  </tr>
</table>";


                echo $quate_view;
                echo $quate_total; //total production cost---------------------------------------------------------
                $total_pro_cost = $tot_service_cost + sales_material_cost($tot_material_cost);





//discount for the product
                    if (discount($pro_id) == 0) {
                        $final_cost = $total_pro_cost;
                        $discount = 0;
                    } else {
                        $discount = ($total_pro_cost * discount($pro_id))/ 100 ;
                        $final_cost = $total_pro_cost - $discount;
                    }
                    $adv_pay = $final_cost / 2;


                $quate_view = "
         <table style='width:100%' align='left' class ='table table-striped text-white'>
         <tr>
    <td colspan='2'><div><h4> " . pro_name($pro_id) . " Quote </h4> <br></div> </td>
       
  </tr>
  <tr>
    <td>Inner Paper Cost   </td>
    <td> Rs. " . number_format(sales_material_cost($ppr_cost)) . "</td>   
  </tr>
  
  <tr>
    <td>Ink Cost</td>
    <td> Rs. " . number_format(sales_material_cost($ink_cost)) . "</td>   
  </tr>
 
  <tr>
    <td>Laminate Paper Cost </td>
    <td> Rs. " . number_format(sales_material_cost($laminate_cost)) . "</td>    
  </tr>
  <tr>
    <td><h5>Total Material Cost</h5> </td>
    <td><h5> Rs. " . number_format(sales_material_cost($tot_material_cost), 2) . "</h5></td>
  </tr>
</table> <br> 
<table style='width:100%' class ='table table-striped text-white'>
  <tr>
    <td>Designing Cost</td>
    <td> Rs. " . number_format($design_cost, 2) . "</td>   
  </tr>
  
  <tr>
    <td>Printing Cost</td>
    <td> Rs. " . number_format($print_cost, 2) . "</td>   
  </tr>
  <tr>
    
  <tr>
    <td>Cover Laminating Cost </td>
    <td> Rs. " . number_format($laminating_cost, 2) . "</td>    
  </tr>
  
  <tr>
    <td>Die Cutting Cost</td>
    <td> Rs. " . number_format($die_cutting_cost, 2) . "</td>
  </tr>
  <tr>
    <td><h5>Total Service Cost</h5> </td>
    <td><h5> Rs. " . number_format($tot_service_cost, 2) . "</h5> </td>
  </tr>
</table> <br>
 ";





                $quate_total = "<table style='width:100%' align='left' class ='table table-striped text-white' > ";

                if (discount($pro_id) != 0) {
                    $quate_total .= " <tr>
                             <td><h5>Grand Total </h5></td>
                             <td><h5>Rs. " . number_format($tot_service_cost + sales_material_cost($tot_material_cost), 2) . " </h5></td>
                             </tr> 
                            <tr>
                            <td><h5> Discount of (" . discount($pro_id) . " %) </h5> </td><td><h5> Rs." . number_format($discount, 2) . "</h5></td></tr>"
                            . "     <tr><td><h5> Net Amount </h5> </td> <td><h5>  Rs." . number_format($final_cost, 2) . "</h5></td></tr>";
                } else {
                    $quate_total .= "<tr><td><h5> Net Amount </h5></td> <td><h5>  Rs. " . number_format($final_cost, 2) . "</h5></td></tr>";
                }" ";
                $quate_total .= "<tr>
    <td</td>
    <td></td>
  </tr>
  <tr>
    <td colspan='2' > To Conferm the order minimum advance payment is Rs. " . number_format($adv_pay, 2) . " </td>
    
  </tr>
</table>";


                echo $quate_view;
                echo $quate_total;
            }
            break;
//------------------------business card-----------------------------------------
        case 11:
            //define variable
            $ppr_size = $ppr_color = $ppr_thick = $ink_unit_price = $print = $laminate = $ppr_cost = $print_type = $ink_cost = $length = $width = $serface = $width_id = null;
            //Asign value
            $width_id = 101; // value_id
            //standerd sizes(width and length) of business card
            $width = 89;
            $length = 51;
            $shape = $_POST['shape#11'];
            if (isset($_POST['printing_side#12'])) {
                $print_side = $_POST['printing_side#12'];
            }
            $ppr_thick = clean_input($_POST['cover_paper_thick#8']);
            if (isset($_POST['print#37'])) {
                $print = clean_input($_POST['print#37']);
            }
            $laminate = clean_input($_POST['laminate_type#13']);
            $print_type = 149; //offset print
            $serface = 0.9; // offset serface of print
            //empty validation-------------------------------------------------- 
            if (empty($shape)) {
                echo "<div class='alert alert-danger'>Shape shoud not be empty</div>";
                $e = 0;
            }
            if (empty($ppr_thick)) {
                echo "<div class='alert alert-danger'>Paper thick shoud not be empty</div>";
                $e = 0;
            }
            if (empty($print_side)) {
                echo "<div class='alert alert-danger'>Print side shoud not be empty</div>";
                $e = 0;
            }
            if (empty($print)) {
                echo "<div class='alert alert-danger'>Print type shoud not be empty</div>";
                $e = 0;
            }
            if (empty($laminate)) {
                echo "<div class='alert alert-danger'>Laminate type shoud not be empty</div>";
                $e = 0;
            }

            //end empty validation----------------------------------------------

            if ($e != 0) {

                //sql for order properties
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','11','" . $shape . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','8','" . $ppr_thick . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','12','" . $print_side . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','37','" . $print . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','13','" . $laminate . "')";

//1 paper-----------------------------------------------------------------------
                //is available in stock
                if (avlable_itm_max_price(8, $width_id, $ppr_thick) == 0) {
                    $e = 0;
                    break;
                }
                $ppr_cost = avlable_itm_max_price(8, $width_id, $ppr_thick) * $length * $pro_qty;
                $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(8, $width_id, $ppr_thick) . "','" . $length * $pro_qty . "')";

//end paper---------------------------------------------------------------------
//2 ink ------------------------------------------------------------------------
                if ($print == 161) {// color 1/1 black
                    $color_type = 46; // black
                    //is available in stock
                    if (avlable_itm_max_price(5, $color_type, $print_type) == 0) {
                        $e = 0;
                        break;
                    }
                    $ink_unit_price = avlable_itm_max_price(5, $color_type, $print_type);
                } elseif ($print == 162) {//color 4/4 cmyk
                    // price for all 4 colors 
                    for ($color_type = 43; $color_type <= 46; $color_type++) {
                        //is available in stock
                        if (avlable_itm_max_price(5, $color_type, $print_type) == 0) {
                            $e = 0;
                            break;
                        }
                        $ink_unit_price += avlable_itm_max_price(5, $color_type, $print_type);
                    }
                }
                if ($print_side == 8) {//single side
                    $ink_cost = $ink_unit_price * $pro_qty * $length * $width * $serface / 1000000;
                } elseif ($print_side == 9) {// double side
                    $ink_cost = $ink_unit_price * $pro_qty * $length * $width * $serface * 2 / 1000000;
                }


                if ($print_side == 8) {//single side
                    if ($print == 161) {// color 1/1 black
                        $color_type = 46; // black

                        $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $color_type, $print_type) . "','" . (( $pro_qty * $length * $width * $serface ) / 1000000) . "')";
                    } elseif ($print == 162) {//color 4/4 cmyk
                        // price for all 4 colors 
                        for ($color_type = 43; $color_type <= 46; $color_type++) {

                            $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $color_type, $print_type) . "','" . (( $pro_qty * $length * $width * $serface ) / 1000000) . "')";
                        }
                    }
                } elseif ($print_side == 9) {// double side
                    if ($print == 161) {// color 1/1 black
                        $color_type = 46; // black

                        $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $color_type, $print_type) . "','" . (( $pro_qty * $length * $width * $serface * 2 ) / 1000000) . "')";
                    } elseif ($print == 162) {//color 4/4 cmyk
                        // price for all 4 colors 
                        for ($color_type = 43; $color_type <= 46; $color_type++) {

                            $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $color_type, $print_type) . "','" . (( $pro_qty * $length * $width * $serface * 2 ) / 1000000) . "')";
                        }
                    }
                }
//end ink-----------------------------------------------------------------------
//laminate----------------------------------------------------------------------
                if ($laminate != 6) {
                    //is available in stock
                    if (avlable_itm_max_price(10, $width_id, $laminate) == 0) {
                        $e = 0;
                        break;
                    }
                    "laminate" . $laminate_cost = avlable_itm_max_price(10, $width_id, $laminate) * $pro_qty * $length;
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(10, $width_id, $laminate) . "','" . ($pro_qty * $length) . "')";
                } else {
                    $laminate_cost = 0;
                }
//end laminate------------------------------------------------------------------
//total quate for meterials-----------------------------------------------------
                $tot_material_cost = $ink_cost + $ppr_cost + $laminate_cost;
                // sales price of item 30% added to actual cost
                "Total Cost Of Paper( Standerd Business Card size x " . $pro_qty . " Sheets  ) : " . sales_material_cost($ppr_cost);

                "Total Ink Cost For Print ( Width " . $width . "(mm) x Length " . $length . "(mm)  Quantity of " . $pro_qty . ") : " . sales_material_cost($ink_cost);

                "Total Cost Of  Laminate (" . $width . "(mm) x " . $length . "(mm) x Quantity of " . $pro_qty . ") : " . sales_material_cost($laminate_cost);

                "Total Cost Of Materials : " . round(sales_material_cost($tot_material_cost), 2);
//service cost------------------------------------------------------------------
//designing cost----------------------------------------------------------------            
                "task cost of designing :" . $design_cost = task_cost(7, $width * $length);
//printing----------------------------------------------------------------------
                $print_cost = task_cost(1, $width * $length * $pro_qty);
                if ($print == 162) {// color 4/4  cmyk
                    $print_cost = $print_cost * 4;
                }
                "printing cost : " . $print_cost;
//laminating--------------------------------------------------------------------
                if ($laminate != 6) {// not non laminate type
                    "task cost of laminating :" . $laminating_cost = task_cost(5, $width * $length * $pro_qty);
                } else {
                    $laminating_cost = 0;
                }
                "laminatin cost : " . $laminating_cost;
//die cutting cost--------------------------------------------------------------
                if ($pro_qty % 25 == 0) {
                    $die_cutting_cost = task_cost(4, $pro_qty / 25);
                } else {
                    $die_cutting_cost = task_cost(4, floor($pro_qty / 25) + 1);
                }
                if ($shape != 28) {//if not a standerd shape             
                    $die_cutting_cost = $die_cutting_cost * 1.1;
                }


                "task cost of shape cutting :" . $die_cutting_cost;
//Total service cost of business card-------------------------------------------
                $tot_service_cost = $design_cost + $print_cost + $laminating_cost + $die_cutting_cost;
                "Total service cost :" . round($tot_service_cost);
//                "Total Production cost : " . $total_pro_cost = $tot_service_cost, 2) + round(sales_material_cost($tot_material_cost), 2));
            

            $total_pro_cost = number_format($tot_service_cost + sales_material_cost($tot_material_cost), 2);


///discount for the product
                    if (discount($pro_id) == 0) {
                        $final_cost = $total_pro_cost;
                        $discount = 0;
                    } else {
                        $discount = ($total_pro_cost * discount($pro_id))/ 100 ;
                        $final_cost = $total_pro_cost - $discount;
                    }
                    $adv_pay = $final_cost / 2;


            $quate_view = "
         <table style='width:100%' align='left' class ='table table-striped text-white'>
         <tr>
    <td colspan='2'><div><h4> " . pro_name($pro_id) . " Quote </h4> <br></div> </td>
       
  </tr> 
  <tr>
    <td>Paper Cost   </td>
    <td> Rs. " . number_format(sales_material_cost($ppr_cost)) . "</td>   
  </tr>
  
  <tr>
    <td>Ink Cost</td>
    <td> Rs. " . number_format(sales_material_cost($ink_cost)) . "</td>   
  </tr>
 
  <tr>
    <td>Laminate Paper Cost </td>
    <td> Rs. " . number_format(sales_material_cost($laminate_cost)) . "</td>    
  </tr>
  <tr>
    <td><h5>Total Material Cost</h5> </td>
    <td><h5> Rs. " . number_format(sales_material_cost($tot_material_cost), 2) . "</h5></td>
  </tr>
</table> <br> 
<table style='width:100%' class ='table table-striped text-white'>
  <tr>
    <td>Designing Cost</td>
    <td> Rs. " . number_format($design_cost, 2) . "</td>   
  </tr>
  
  <tr>
    <td>Printing Cost</td>
    <td> Rs. " . number_format($print_cost, 2) . "</td>   
  </tr>
  <tr>
    
  <tr>
    <td>Cover Laminating Cost </td>
    <td> Rs. " . number_format($laminating_cost, 2) . "</td>    
  </tr>
  
  <tr>
    <td>Die Cutting Cost</td>
    <td> Rs. " . number_format($die_cutting_cost, 2) . "</td>
  </tr>
  <tr>
    <td><h5>Total Service Cost</h5> </td>
    <td><h5> Rs. " . number_format($tot_service_cost, 2) . "</h5> </td>
  </tr>
</table> <br>
 ";





            $quate_total = "<table style='width:100%' align='left' class ='table table-striped text-white' > ";

            if (discount($pro_id) != 0) {
                $quate_total .= " <tr>
                             <td><h5>Grand Total </h5></td>
                             <td><h5>Rs. " . number_format($tot_service_cost + sales_material_cost($tot_material_cost), 2) . " </h5></td>
                             </tr> 
                            <tr>
                            <td><h5> Discount of (" . discount($pro_id) . " %) </h5> </td><td><h5> Rs." . number_format($discount, 2) . "</h5></td></tr>"
                        . "     <tr><td><h5> Net Amount </h5> </td> <td><h5>  Rs." . number_format($final_cost, 2) . "</h5></td></tr>";
            } else {
                $quate_total .= "<tr><td><h5> Net Amount </h5></td> <td><h5>  Rs. " . number_format($final_cost, 2) . "</h5></td></tr>";
            }" ";
            $quate_total .= "<tr>
    <td</td>
    <td></td>
  </tr>
  <tr>
    <td colspan='2' > To Conferm the order minimum advance payment is Rs. " . number_format($adv_pay, 2) . " </td>
    
  </tr>
</table>";


            echo $quate_view;
            echo $quate_total;





            }


            break;
//-----------------------------------mug----------------------------------------
        case 13:
            //define variable
            $mug_vol = $mug_color = $print = $ink_unit_price = $height = $radious = null;
            //Asign value
            $mug_vol = clean_input($_POST['mug_volume#28']);
            $mug_color = clean_input($_POST['mug_colour#29']);
            if (isset($_POST['print#37'])) {
                $print = $_POST['print#37'];
            }
            $serface = 1.5;

            //empty validation-------------------------------------------------- 
            if (empty($mug_vol)) {
                echo "<div class='alert alert-danger'>Shape shoud not be empty</div>";
                $e = 0;
            }
            if (empty($mug_color)) {
                echo "<div class='alert alert-danger'>Paper thick shoud not be empty</div>";
                $e = 0;
            }
            if (empty($print)) {
                echo "<div class='alert alert-danger'>Print type shoud not be empty</div>";
                $e = 0;
            }

            //end empty validation----------------------------------------------
            if ($e != 0) {

                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','28','" . $mug_vol . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','29','" . $mug_color . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','37','" . $print . "')";




// 1 mug------------------------------------------------------------------------
                //is available in stock
                if (avlable_itm_max_price(11, $mug_vol, $mug_color) == 0) {
                    $e = 0;
                    break;
                }
                $mug_cost = avlable_itm_max_price(11, $mug_vol, $mug_color) * $pro_qty;
                $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(11, $mug_vol, $mug_color) . "','" . $pro_qty . "')";
//end mug-----------------------------------------------------------------------
//2 sublimation paper-----------------------------------------------------------       
                // mug height
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $mug_vol AND property_id = 23";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    "height" . $height = $row['value'];

                    $sql_h_id = "SELECT `property_value_id` FROM `tb_product_property_value` WHERE value = $height and property_id = 23";
                    $result = $conn->query($sql_h_id);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $height_id = $row['property_value_id'];
                    }
                }

                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $mug_vol AND property_id = 38";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $mug_diameter = $row['value'];
                }
//is available in stock
                if (avlable_itm_max_price(13, $height_id) == 0) {
                    $e = 0;
                    break;
                }
                $ppr_cost = avlable_itm_max_price(13, $height_id) * $mug_diameter * pi() * $pro_qty;
                $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(13, $height_id) . "','" . $mug_diameter * pi() * $pro_qty . "')";
//end sublimation paper---------------------------------------------------------
//3 sublimation ink-------------------------------------------------------------
//colourtype
                if ($print == 161) {// color 1/1 black
                    $color_type = 46; // black
                    //is available in stock
                    if (avlable_itm_max_price(12, $color_type) == 0) {
                        $e = 0;
                        break;
                    }
                    $ink_unit_price = avlable_itm_max_price(12, $color_type);
                } elseif ($print == 162) {//color 4/4 cmyk
                    // price for all 4 colors 
                    for ($color_type = 43; $color_type <= 46; $color_type++) {
                        //is available in stock
                        if (avlable_itm_max_price(12, $color_type) == 0) {
                            $e = 0;
                            break;
                        }
                        $ink_unit_price += avlable_itm_max_price(5, $color_type);
                    }
                }
                "ink cost" . $ink_cost = $ink_unit_price * ink_qty($mug_diameter * pi() * $height, $serface) * $pro_qty;



                if ($print == 161) {// color 1/1 black
                    $color_type = 46; // black
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(12, $color_type) . "','" . ink_qty($mug_diameter * pi() * $height, $serface) * $pro_qty . "')";
                } elseif ($print == 162) {//color 4/4 cmyk
                    // price for all 4 colors 
                    for ($color_type = 43; $color_type <= 46; $color_type++) {
                        $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(12, $color_type) . "','" . ink_qty($mug_diameter * pi() * $height, $serface) * $pro_qty . "')";
                    }
                }


//end sublimation ink-----------------------------------------------------------
//total quate for meterials-----------------------------------------------------
                $tot_material_cost = $ink_cost + $ppr_cost + $mug_cost;
                // sales price of item 30% added to actual cost
                 "Total Cost Of Mug" . pro_id_to_val($mug_vol) . " x " . $pro_qty . " Mugs ) : " . sales_material_cost($mug_cost);
                 "Total Cost Of Paper( sublimation paper width : " . $height . "(mm) x length (mm)" . round(pi() * $mug_diameter, 2) . " Quantity of " . $pro_qty . " Sheets  ) : " . sales_material_cost($ppr_cost);
                 "Total Ink Cost For Print ( Height " . $height . "(mm) x Deiameter " . round(pi() * $mug_diameter, 2) . "(mm)  Quantity of " . $pro_qty . ") : " . sales_material_cost($ink_cost);
                "Total Cost Of Materials : " . round(sales_material_cost($tot_material_cost), 2);

//service cost------------------------------------------------------------------
//
//designing cost----------------------------------------------------------------            
                 "task cost of designing :" . $design_cost = task_cost(7, $mug_diameter * pi() * $height);
//printing----------------------------------------------------------------------
                $print_cost = task_cost(10, $mug_diameter * pi() * $height * $pro_qty);
                if ($print == 162) {// color 4/4  cmyk
                    $print_cost = $print_cost * 4;
                }
                 "printing cost : " . $print_cost;

//Total service cost of business card-------------------------------------------
                $tot_service_cost = $design_cost + $print_cost;
                "Total service cost :" . round($tot_service_cost);
//                "Total Production cost : " . $total_pro_cost = (round($tot_service_cost, 2) + round(sales_material_cost($tot_material_cost), 2));
                
                
                                  $total_pro_cost = $tot_service_cost + sales_material_cost($tot_material_cost);


//discount for the product
                    if (discount($pro_id) == 0) {
                        $final_cost = $total_pro_cost;
                        $discount = 0;
                    } else {
                        $discount = ($total_pro_cost * discount($pro_id))/ 100 ;
                        $final_cost = $total_pro_cost - $discount;
                    }
                    $adv_pay = $final_cost / 2;


                    $quate_view = "
         <table style='width:100%' align='left' class ='table table-striped text-white'>
         <tr>
    <td colspan='2'><div><h4> " . pro_name($pro_id) . " Quote </h4> <br></div> </td>
       
  </tr> 
  <tr>
    <td>Sublimation Paper Cost   </td>
    <td> Rs. " . number_format(sales_material_cost($ppr_cost)) . "</td>   
  </tr>
  
  <tr>
    <td>Ink Cost</td>
    <td> Rs. " . number_format(sales_material_cost($ink_cost)) . "</td>   
  </tr>
 
  <tr>
    <td>Mug Cost </td>
    <td> Rs. " . number_format(sales_material_cost($mug_cost)) . "</td>    
  </tr>
  <tr>
    <td><h5>Total Material Cost</h5> </td>
    <td><h5> Rs. " . number_format(sales_material_cost($tot_material_cost), 2) . "</h5></td>
  </tr>
</table> <br> 
<table style='width:100%' class ='table table-striped text-white'>
  <tr>
    <td>Designing Cost</td>
    <td> Rs. " . number_format($design_cost, 2) . "</td>   
  </tr>
  
  <tr>
    <td>Printing Cost</td>
    <td> Rs. " . number_format($print_cost, 2) . "</td>   
  </tr>
  <tr>
  
  <tr>
    <td><h5>Total Service Cost</h5> </td>
    <td><h5> Rs. " . number_format($tot_service_cost, 2) . "</h5> </td>
  </tr>
</table> <br>
 ";





                    $quate_total = "<table style='width:100%' align='left' class ='table table-striped text-white' > ";

                    if (discount($pro_id) != 0) {
                        $quate_total .= " <tr>
                             <td><h5>Grand Total </h5></td>
                             <td><h5>Rs. " . number_format($tot_service_cost + sales_material_cost($tot_material_cost), 2) . " </h5></td>
                             </tr> 
                            <tr>
                            <td><h5> Discount of (" . discount($pro_id) . " %) </h5> </td><td><h5> Rs." . number_format($discount, 2) . "</h5></td></tr>"
                                . "     <tr><td><h5> Net Amount </h5> </td> <td><h5>  Rs." . number_format($final_cost, 2) . "</h5></td></tr>";
                    } else {
                        $quate_total .= "<tr><td><h5> Net Amount </h5></td> <td><h5>  Rs. " . number_format($final_cost, 2) . "</h5></td></tr>";
                    }" ";
                    $quate_total .= "<tr>
    <td</td>
    <td></td>
  </tr>
  <tr>
    <td colspan='2' > To Conferm the order minimum advance payment is Rs. " . number_format($adv_pay, 2) . " </td>
    
  </tr>
</table>";
                    echo $quate_view;
                    echo $quate_total;
                
                
                
            }
            break;
//------------------------------letterhead--------------------------------------
        case 16:
            //define variable
            $ppr_size = $ppr_color = $ppr_thick = $ink_unit_price = $print = $ppr_cost = $print_type = $ink_cost = $length = $width = $serface = $width_id = null;
            //Asign value
            $ppr_size = clean_input($_POST['paper_size#1']);
            $ppr_thick = clean_input($_POST['paper_thick#7']);
            $ppr_color = clean_input($_POST['paper_colour#2']);
            if (isset($_POST['print#37'])) {
                $print = $_POST['print#37'];
            }
            $print_type = 149; //offset print
            $serface = 0.9; // offset serface of print
            //empty validation-------------------------------------------------- 
            if (empty($ppr_size)) {
                 "<div class='alert alert-danger'> Paper size shoud not be empty</div>";
                $e = 0;
            }
            if (empty($ppr_thick)) {
                echo "<div class='alert alert-danger'>Paper thick shoud not be empty</div>";
                $e = 0;
            }
            if (empty($ppr_color)) {
                echo "<div class='alert alert-danger'>Paper colour shoud not be empty</div>";
                $e = 0;
            }
            if (empty($print)) {
                echo "<div class='alert alert-danger'>Print type shoud not be empty</div>";
                $e = 0;
            }
            //end empty validation----------------------------------------------

            if ($e != 0) {


                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','1','" . $ppr_size . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','7','" . $ppr_thick . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','2','" . $ppr_color . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','37','" . $print . "')";


//1 paper----------------------------------------------------------------------- 
                //is available in stock
                if (avlable_itm_max_price(1, $ppr_size, $ppr_thick, $ppr_color) == 0) {
                    $e = 0;
                    break;
                }
                //paper cost
                $ppr_cost = ( avlable_itm_max_price(1, $ppr_size, $ppr_thick, $ppr_color) * $pro_qty);
                $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(1, $ppr_size, $ppr_thick, $ppr_color) . "','" . $pro_qty . "')";
//end paper---------------------------------------------------------------------
//2 ink ------------------------------------------------------------------------
                if ($print == 161) {// color 1/1 black
                    $color_type = 46; // black
                    //is available in stock
                    if (avlable_itm_max_price(5, $color_type, $print_type) == 0) {
                        $e = 0;
                        break;
                    }
                    $ink_unit_price = avlable_itm_max_price(5, $color_type, $print_type);
                } elseif ($print == 162) {//color 4/4 cmyk
                    // price for all 4 colors 
                    for ($color_type = 43; $color_type <= 46; $color_type++) {
                        //is available in stock
                        if (avlable_itm_max_price(5, $color_type, $print_type) == 0) {
                            $e = 0;
                            break;
                        }
                        $ink_unit_price += avlable_itm_max_price(5, $color_type, $print_type);
                    }
                }

                // width and length for printing serface area 
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $ppr_size AND property_id = 23";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $length = $row['value'];
                }
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $ppr_size AND property_id = 22";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $width = $row['value'];
                }

                 $ink_cost = $ink_unit_price * $pro_qty * $length * $width * $serface / 1000000;


                if ($print == 161) {// color 1/1 black
                    $color_type = 46; // black
                    //is available in stock
                    if (avlable_itm_max_price(5, $color_type, $print_type) == 0) {
                        $e = 0;
                        break;
                    }
                    $ink_unit_price = avlable_itm_max_price(5, $color_type, $print_type);
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $color_type, $print_type) . "','" . (($pro_qty * $length * $width * $serface) / 1000000) . "')";
                } elseif ($print == 162) {//color 4/4 cmyk
                    // price for all 4 colors 
                    for ($color_type = 43; $color_type <= 46; $color_type++) {

                        $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $color_type, $print_type) . "','" . (($pro_qty * $length * $width * $serface) / 1000000) . "')";
                    }
                }

//end ink-----------------------------------------------------------------------
//total quate for meterials-----------------------------------------------------
                $tot_material_cost = $ink_cost + $ppr_cost;
                // sales price of item 30% added to actual cost
                 "Total Cost Of Paper(" . pro_id_to_val($ppr_size) . " x " . $pro_qty . " Sheets  ) : " . sales_material_cost($ppr_cost);

                 "Total Ink Cost For Print ( Width " . $width . "(mm) x Length " . $length . "(mm)  Quantity of " . $pro_qty . ") : " . sales_material_cost($ink_cost);

                "Total Cost Of Materials : " . round(sales_material_cost($tot_material_cost), 2);

// service cost-----------------------------------------------------------------
//01 design---------------------------------------------------------------------
                 "task cost of designing :" . $design_cost = task_cost(7, $width * $length);
//02 printing-------------------------------------------------------------------
                $print_cost = task_cost(1, $width * $length * $pro_qty);
                if ($print == 162) {// color 4/4  cmyk
                    $print_cost = $print_cost * 4;
                }

//03 diecutting-----------------------------------------------------------------
                if ($pro_qty % 50 == 0) {
                    $die_cutting_cost = task_cost(4, $pro_qty / 50);
                } else {
                    $die_cutting_cost = task_cost(4, floor($pro_qty / 50) + 1);
                }
                 "task cost of die cutting :" . $die_cutting_cost;
// Total service cost ----------------------------------------------------------           
                $tot_service_cost = $design_cost + $print_cost + $die_cutting_cost;
                "Total Cost Of Service : " . round($tot_service_cost, 2);
//total production cost---------------------------------------------------------
                "Total Production cost : " . $total_pro_cost = (round($tot_service_cost, 2) + round(sales_material_cost($tot_material_cost), 2));
                
                
                


                    $total_pro_cost = number_format($tot_service_cost + sales_material_cost($tot_material_cost), 2);


///discount for the product
                    if (discount($pro_id) == 0) {
                        $final_cost = $total_pro_cost;
                        $discount = 0;
                    } else {
                        $discount = ($total_pro_cost * discount($pro_id))/ 100 ;
                        $final_cost = $total_pro_cost - $discount;
                    }
                    $adv_pay = $final_cost / 2;


                    $quate_view = "
         <table style='width:100%' align='left' class ='table table-striped text-white'>
         <tr>
    <td colspan='2'><div><h4> " . pro_name($pro_id) . " Quote </h4> <br></div> </td>
       
  </tr> 
  <tr>
    <td>Paper Cost   </td>
    <td> Rs. " . number_format(sales_material_cost($ppr_cost)) . "</td>   
  </tr>
  
  <tr>
    <td>Ink Cost</td>
    <td> Rs. " . number_format(sales_material_cost($ink_cost)) . "</td>   
  </tr>
  <tr>
    <td><h5>Total Material Cost</h5> </td>
    <td><h5> Rs. " . number_format(sales_material_cost($tot_material_cost), 2) . "</h5></td>
  </tr>
</table> <br> 
<table style='width:100%' class ='table table-striped text-white'>
  <tr>
    <td>Designing Cost</td>
    <td> Rs. " . number_format($design_cost, 2) . "</td>   
  </tr>
  
  <tr>
    <td>Printing Cost</td>
    <td> Rs. " . number_format($print_cost, 2) . "</td>   
  </tr>
  <tr>
   
  
  <tr>
    <td>Die Cutting Cost</td>
    <td> Rs. " . number_format($die_cutting_cost, 2) . "</td>
  </tr>
  <tr>
    <td><h5>Total Service Cost</h5> </td>
    <td><h5> Rs. " . number_format($tot_service_cost, 2) . "</h5> </td>
  </tr>
</table> <br>
 ";





                    $quate_total = "<table style='width:100%' align='left' class ='table table-striped text-white' > ";

                    if (discount($pro_id) != 0) {
                        $quate_total .= " <tr>
                             <td><h5>Grand Total </h5></td>
                             <td><h5>Rs. " . number_format($tot_service_cost + sales_material_cost($tot_material_cost), 2) . " </h5></td>
                             </tr> 
                            <tr>
                            <td><h5> Discount of (" . discount($pro_id) . " %) </h5> </td><td><h5> Rs." . number_format($discount, 2) . "</h5></td></tr>"
                                . "     <tr><td><h5> Net Amount </h5> </td> <td><h5>  Rs." . number_format($final_cost, 2) . "</h5></td></tr>";
                    } else {
                        $quate_total .= "<tr><td><h5> Net Amount </h5></td> <td><h5>  Rs. " . number_format($final_cost, 2) . "</h5></td></tr>";
                    }" ";
                    $quate_total .= "<tr>
    <td</td>
    <td></td>
  </tr>
  <tr>
    <td colspan='2' > To Conferm the order minimum advance payment is Rs. " . number_format($adv_pay, 2) . " </td>
    
  </tr>
</table>";


                    echo $quate_view;
                    echo $quate_total;
                
                
                
                
            }
            break;
//----------------------------invitation----------------------------------------
        case 17:
            //define variable
            $ppr_size = $ppr_color = $ppr_thick = $ink_unit_price = $print = $laminate = $ppr_cost = $print_type = $ink_cost = $length = $width = $serface = $width_id = null;
            //Asign value
            $ppr_size = clean_input($_POST['paper_size#1']);
            $ppr_thick = clean_input($_POST['cover_paper_thick#8']);
            if (isset($_POST['print#37'])) {
                $print = $_POST['print#37'];
            }
            $laminate = clean_input($_POST['laminate_type#13']);
            $print_type = 149; //offset print
            $serface = 0.9; // offset serface of print
            //empty validation-------------------------------------------------- 
            if (empty($ppr_size)) {
                echo "<div class='alert alert-danger'> Paper size shoud not be empty</div>";
                $e = 0;
            }
            if (empty($ppr_thick)) {
                echo "<div class='alert alert-danger'>Paper thick shoud not be empty</div>";
                $e = 0;
            }
            
            if (empty($print)) {
                echo "<div class='alert alert-danger'>Print type shoud not be empty</div>";
                $e = 0;
            }
            if (empty($laminate)) {
                echo "<div class='alert alert-danger'>Laminate type shoud not be empty</div>";
                $e = 0;
            }
            //end empty validation----------------------------------------------
            if ($e != 0) {
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','1','" . $ppr_size . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','8','" . $ppr_thick . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','13','" . $laminate . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','37','" . $print . "')";


//1 paper-----------------------------------------------------------------------            
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $ppr_size AND property_id = 23";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $length = $row['value'];
                }

                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $ppr_size AND property_id = 22";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $width = $row['value'];

                    $sql_w_id = "SELECT `property_value_id`, `property_id`, `value` FROM `tb_product_property_value` WHERE value = $width  and property_id = 22";
                    $result = $conn->query($sql_w_id);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $width_id = $row['property_value_id'];
                    }
                }
                //is available in stock
                if (avlable_itm_max_price(8, $width_id, $ppr_thick) == 0) {
                    $e = 0;
                    break;
                }
                $ppr_cost = avlable_itm_max_price(8, $width_id, $ppr_thick) * $length * $pro_qty;

                $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(8, $width_id, $ppr_thick) . "','" . ( $length * $pro_qty) . "')";
//end paper---------------------------------------------------------------------
//2 ink ------------------------------------------------------------------------
                if ($print == 161) {// color 1/1 black
                    $color_type = 46; // black
                    //is in stock
                    if (avlable_itm_max_price(5, $color_type, $print_type) == 0) {
                        $e = 0;
                        break;
                    }
                     $ink_unit_price = avlable_itm_max_price(5, $color_type, $print_type);
                } elseif ($print == 162) {//color 4/4 cmyk
                    // price for all 4 colors 
                    for ($color_type = 43; $color_type <= 46; $color_type++) {
                        //is in stock
                        if (avlable_itm_max_price(5, $color_type, $print_type) == 0) {
                            $e = 0;
                            break;
                        }
                        $ink_unit_price += avlable_itm_max_price(5, $color_type, $print_type);
                    }
                }
                 $ink_cost = $ink_unit_price * $pro_qty * $length * $width * $serface / 1000000;


                if ($print == 161) {// color 1/1 black
                    $color_type = 46; // black
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $color_type, $print_type) . "','" . (($pro_qty * $length * $width * $serface) / 1000000) . "')";
                } elseif ($print == 162) {//color 4/4 cmyk
                    // price for all 4 colors 
                    for ($color_type = 43; $color_type <= 46; $color_type++) {
                        $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $color_type, $print_type) . "','" . (($pro_qty * $length * $width * $serface) / 1000000) . "')";
                    }
                }


//end ink-----------------------------------------------------------------------
//laminate----------------------------------------------------------------------



                if ($laminate != 6) {

                    //is available in stock
                    if (avlable_itm_max_price(10, $width_id, $laminate) == 0) {
                        $e = 0;
                        break;
                    }

                    $laminate_cost = avlable_itm_max_price(10, $width_id, $laminate) * $pro_qty * $length;
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(10, $width_id, $laminate) . "','" . ($pro_qty * $length) . "')";
                } else {
                    $laminate_cost = 0;
                }


//end laminate------------------------------------------------------------------
//total quate for meterials-----------------------------------------------------
                $tot_material_cost = $ink_cost + $ppr_cost + $laminate_cost;
                // sales price of item 30% added to actual cost
                 "Total Cost Of Paper(" . pro_id_to_val($ppr_size) . "x " . $pro_qty . " Sheets  ) : " . $ppr_cost * 1.3;

                 "Total Ink Cost For Print ( Width " . $width . "(mm) x Length " . $length . "(mm)  Quantity of " . $pro_qty . ") : " . $ink_cost * 1.3;

                 "Total Cost Of  Laminate (" . $width . "(mm) x " . $length . "(mm) x Quantity of " . $pro_qty . ") : " . $laminate_cost * 1.3;

                "Total Cost Of Materials : " . round($tot_material_cost * 1.3, 2);

//service cost------------------------------------------------------------------
//
//designing cost----------------------------------------------------------------            
                 "task cost of designing :" . $design_cost = task_cost(7, $width * $length);
//printing----------------------------------------------------------------------
                $print_cost = task_cost(1, $width * $length * $pro_qty);
                if ($print == 162) {// color 4/4  cmyk
                    $print_cost = $print_cost * 4;
                }
                 "printing cost : " . $print_cost;
//laminating--------------------------------------------------------------------
                if ($laminate != 6) {// not non laminate type
                     "task cost of laminating :" . $laminating_cost = task_cost(5, $width * $length * $pro_qty);
                } else {
                    $laminating_cost = 0;
                }
                 "laminatin cost : " . $laminating_cost;
//die cutting cost--------------------------------------------------------------
                if ($pro_qty % 50 == 0) {
                    $die_cutting_cost = task_cost(4, $pro_qty / 50);
                } else {
                    $die_cutting_cost = task_cost(4, floor($pro_qty / 50) + 1);
                }
                 "task cost of shape cutting :" . $die_cutting_cost;
//Total service cost of invitation card-------------------------------------------
                $tot_service_cost = $design_cost + $print_cost + $laminating_cost + $die_cutting_cost;
                "Total service cost :" . round($tot_service_cost);
                "Total Production cost : " . $total_pro_cost = (round($tot_service_cost, 2) + round(sales_material_cost($tot_material_cost), 2));
                
                
                
                
                
                
                
                
                
                
                

                    $total_pro_cost = $tot_service_cost + sales_material_cost($tot_material_cost);


                    //discount for the product
                    if (discount($pro_id) == 0) {
                        $final_cost = $total_pro_cost;
                        $discount = 0;
                    } else {
                        $discount = ($total_pro_cost * discount($pro_id))/ 100 ;
                        $final_cost = $total_pro_cost - $discount;
                    }
                    $adv_pay = $final_cost / 2;

                    $quate_view = "
         <table style='width:100%' align='left' class ='table table-striped text-white'>
         <tr>
    <td colspan='2'><div><h4> " . pro_name($pro_id) . " Quote </h4> <br></div> </td>
       
  </tr> 
  <tr>
    <td> Paper Cost   </td>
    <td> Rs. " . number_format(sales_material_cost($ppr_cost)) . "</td>   
  </tr>
  
  <tr>
    <td>Ink Cost</td>
    <td> Rs. " . number_format(sales_material_cost($ink_cost)) . "</td>   
  </tr>
 
  <tr>
    <td>Laminate Paper Cost </td>
    <td> Rs. " . number_format(sales_material_cost($laminate_cost)) . "</td>    
  </tr>
  <tr>
    <td><h5>Total Material Cost</h5> </td>
    <td><h5> Rs. " . number_format(sales_material_cost($tot_material_cost), 2) . "</h5></td>
  </tr>
</table> <br> 
<table style='width:100%' class ='table table-striped text-white'>
  <tr>
    <td>Designing Cost</td>
    <td> Rs. " . number_format($design_cost, 2) . "</td>   
  </tr>
  
  <tr>
    <td>Printing Cost</td>
    <td> Rs. " . number_format($print_cost, 2) . "</td>   
  </tr>
  <tr>
    
  <tr>
    <td>Cover Laminating Cost </td>
    <td> Rs. " . number_format($laminating_cost, 2) . "</td>    
  </tr>
  
  <tr>
    <td>Die Cutting Cost</td>
    <td> Rs. " . number_format($die_cutting_cost, 2) . "</td>
  </tr>
  <tr>
    <td><h5>Total Service Cost</h5> </td>
    <td><h5> Rs. " . number_format($tot_service_cost, 2) . "</h5> </td>
  </tr>
</table> <br>
 ";


                    $quate_total = "<table style='width:100%' align='left' class ='table table-striped text-white' > ";

                    if (discount($pro_id) != 0) {
                        $quate_total .= " <tr>
                             <td><h5>Grand Total </h5></td>
                             <td><h5>Rs. " . number_format($tot_service_cost + sales_material_cost($tot_material_cost), 2) . " </h5></td>
                             </tr> 
                            <tr>
                            <td><h5> Discount of (" . discount($pro_id) . " %) </h5> </td><td><h5> Rs." . number_format($discount, 2) . "</h5></td></tr>"
                                . "     <tr><td><h5> Net Amount </h5> </td> <td><h5>  Rs." . number_format($final_cost, 2) . "</h5></td></tr>";
                    } else {
                        $quate_total .= "<tr><td><h5> Net Amount </h5></td> <td><h5>  Rs. " . number_format($final_cost, 2) . "</h5></td></tr>";
                    }" ";
                    $quate_total .= "<tr>
    <td</td>
    <td></td>
  </tr>
  <tr>
    <td colspan='2' > To Conferm the order minimum advance payment is Rs. " . number_format($adv_pay, 2) . " </td>
    
  </tr>
</table>";

                    echo $quate_view;
                    echo $quate_total;
                
                
                
            }
            break;

//-------------------leaflet----------------------------------------------------
        case 18:
            //define variable
            $ppr_size = $ppr_color = $ppr_thick = $ink_unit_price = $print = $ppr_cost = $print_type = $ink_cost = $length = $width = $serface = $width_id = null;
            //Asign value
            $ppr_size = clean_input($_POST['paper_size#1']);
            $ppr_thick = clean_input($_POST['paper_thick#7']);
            $ppr_color = clean_input($_POST['paper_colour#2']);
            if (isset($_POST['print#37'])) {
                $print = $_POST['print#37'];
            }

            $print_type = 149; //offset print
            $serface = 0.9; // offset serface of print
            //empty validation-------------------------------------------------- 
            if (empty($ppr_size)) {
                echo "<div class='alert alert-danger'> Paper size shoud not be empty</div>";
                $e = 0;
            }
            if (empty($ppr_thick)) {
                echo "<div class='alert alert-danger'>Paper thick shoud not be empty</div>";
                $e = 0;
            }
            if (empty($ppr_color)) {
                echo "<div class='alert alert-danger'>Paper colour shoud not be empty</div>";
                $e = 0;
            }
            if (empty($print)) {
                echo "<div class='alert alert-danger'>Print type shoud not be empty</div>";
                $e = 0;
            }

            //end empty validation----------------------------------------------

            if ($e != 0) {



                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','1','" . $ppr_size . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','7','" . $ppr_thick . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','2','" . $ppr_color . "')";
                $sql_ord_prop[] = "Insert into tb_order_property(order_id,property_id,value) values('#','37','" . $print . "')";

//1 paper-----------------------------------------------------------------------   
                //is available in stock
                if (avlable_itm_max_price(1, $ppr_size, $ppr_thick, $ppr_color) == 0) {
                    $e = 0;
                    break;
                }
                //paper cost
                $ppr_cost = ( avlable_itm_max_price(1, $ppr_size, $ppr_thick, $ppr_color) * $pro_qty);
                $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(1, $ppr_size, $ppr_thick, $ppr_color) . "','" . $pro_qty . "')";
//             "remain quntity : " . $remain_sq = stock_use($pro_qty, 1, $ppr_size, $ppr_thick, $ppr_color);
//end paper---------------------------------------------------------------------
//2 ink ------------------------------------------------------------------------
                if ($print == 161) {// color 1/1 black
                    $color_type = 46; // black
                    //is available in stock
                    if (avlable_itm_max_price(5, $color_type, $print_type) == 0) {
                        $e = 0;
                        break;
                    }
                    $ink_unit_price = avlable_itm_max_price(5, $color_type, $print_type);
                } elseif ($print == 162) {//color 4/4 cmyk
                    // price for all 4 colors 
                    for ($color_type = 43; $color_type <= 46; $color_type++) {
                        //is available in stock
                        if (avlable_itm_max_price(5, $color_type, $print_type) == 0) {
                            $e = 0;
                            break;
                        }
                        $ink_unit_price += avlable_itm_max_price(5, $color_type, $print_type);
                    }
                }

                // width and length for printing serface area 
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $ppr_size AND property_id = 23";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $length = $row['value'];
                }
                $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $ppr_size AND property_id = 22";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $width = $row['value'];
                }

                 $ink_cost = $ink_unit_price * $pro_qty * $length * $width * $serface / 1000000;
                if ($print == 161) {// color 1/1 black
                    $color_type = 46; // black
                    $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $color_type, $print_type) . "','" . (($pro_qty * $length * $width * $serface) / 1000000) . "')";
                } elseif ($print == 162) {//color 4/4 cmyk
                    // price for all 4 colors 
                    for ($color_type = 43; $color_type <= 46; $color_type++) {
                        $sql_ord_acc[] = "INSERT INTO `tb_order_acc`(`order_id`, `acc_id`, `amont`) VALUES('#','" . acc_id(5, $color_type, $print_type) . "','" . (($pro_qty * $length * $width * $serface) / 1000000) . "')";
                    }
                }


//end ink-----------------------------------------------------------------------
//total quate for meterials-----------------------------------------------------
                $tot_material_cost = $ink_cost + $ppr_cost;
                // sales price of item 30% added to actual cost
                 "Total Cost Of Paper(" . pro_id_to_val($ppr_size) . " x " . $pro_qty . " Sheets  ) : " . $ppr_cost * 1.3;

                 "Total Ink Cost For Print ( Width " . $width . "(mm) x Length " . $length . "(mm)  Quantity of " . $pro_qty . ") : " . $ink_cost * 1.3;

                "Total Cost Of Materials : " . round($tot_material_cost * 1.3, 2);


// service cost-----------------------------------------------------------------
//01 design---------------------------------------------------------------------
                 "task cost of designing :" . $design_cost = task_cost(7, $width * $length) / 8;
//02 printing-------------------------------------------------------------------
                $print_cost = task_cost(1, $width * $length * $pro_qty);
                if ($print == 162) {// color 4/4  cmyk
                    $print_cost = $print_cost * 4;
                }
//03 diecutting-----------------------------------------------------------------
                if ($pro_qty % 50 == 0) {
                    $die_cutting_cost = task_cost(4, $pro_qty / 50);
                } else {
                    $die_cutting_cost = task_cost(4, floor($pro_qty / 50) + 1);
                }
                 "task cost of die cutting :" . $die_cutting_cost;
// Total service cost ----------------------------------------------------------           
                $tot_service_cost = $design_cost + $print_cost + $die_cutting_cost;
                "Total Cost Of Service : " . round($tot_service_cost, 2);
//total production cost---------------------------------------------------------
//                "Total Production cost : " . $total_pro_cost = (round($tot_service_cost, 2) + round(sales_material_cost($tot_material_cost), 2));
                
                
                
                    $total_pro_cost = $tot_service_cost + sales_material_cost($tot_material_cost);



                   //discount for the product
                    if (discount($pro_id) == 0) {
                        $final_cost = $total_pro_cost;
                        $discount = 0;
                    } else {
                        $discount = ($total_pro_cost * discount($pro_id))/ 100 ;
                        $final_cost = $total_pro_cost - $discount;
                    }
                    $adv_pay = $final_cost / 2;


                    $quate_view = "
         <table style='width:100%' align='left' class ='table table-striped text-white'>
         <tr>
    <td colspan='2'><div><h4> " . pro_name($pro_id) . " Quote </h4> <br></div> </td>
       
  </tr> 
  <tr>
    <td>Paper Cost   </td>
    <td> Rs. " . number_format(sales_material_cost($ppr_cost)) . "</td>   
  </tr>
  
  <tr>
    <td>Ink Cost</td>
    <td> Rs. " . number_format(sales_material_cost($ink_cost)) . "</td>   
  </tr>
  <tr>
    <td><h5>Total Material Cost</h5> </td>
    <td><h5> Rs. " . number_format(sales_material_cost($tot_material_cost), 2) . "</h5></td>
  </tr>
</table> <br> 
<table style='width:100%' class ='table table-striped text-white'>
  <tr>
    <td>Designing Cost</td>
    <td> Rs. " . number_format($design_cost, 2) . "</td>   
  </tr>
  
  <tr>
    <td>Printing Cost</td>
    <td> Rs. " . number_format($print_cost, 2) . "</td>   
  </tr>
  <tr>
  <tr>
    <td>Die Cutting Cost</td>
    <td> Rs. " . number_format($die_cutting_cost, 2) . "</td>
  </tr>
  <tr>
    <td><h5>Total Service Cost</h5> </td>
    <td><h5> Rs. " . number_format($tot_service_cost, 2) . "</h5> </td>
  </tr>
</table> <br>
 ";





                    $quate_total = "<table style='width:100%' align='left' class ='table table-striped text-white' > ";

                    if (discount($pro_id) != 0) {
                        $quate_total .= " <tr>
                             <td><h5>Grand Total </h5></td>
                             <td><h5>Rs. " . number_format($tot_service_cost + sales_material_cost($tot_material_cost), 2) . " </h5></td>
                             </tr> 
                            <tr>
                            <td><h5> Discount of (" . discount($pro_id) . " %) </h5> </td><td><h5> Rs." . number_format($discount, 2) . "</h5></td></tr>"
                                . "     <tr><td><h5> Net Amount </h5> </td> <td><h5>  Rs." . number_format($final_cost, 2) . "</h5></td></tr>";
                    } else {
                        $quate_total .= "<tr><td><h5> Net Amount </h5></td> <td><h5>  Rs. " . number_format($final_cost, 2) . "</h5></td></tr>";
                    }" ";
                    $quate_total .= "<tr>
    <td</td>
    <td></td>
  </tr>
  <tr>
    <td colspan='2' > To Conferm the order minimum advance payment is Rs. " . number_format($adv_pay, 2) . " </td>
    
  </tr>
</table>";


                    echo $quate_view;
                    echo $quate_total;

                
                
                
            }
            break;
        default :
    }






    if ($e == 1) {




        $sql_order = "INSERT INTO tb_order(product_id,qty,comment,cus_name,d_address,email,tp_no,date,order_status,production_cost,discount)"
                . "VALUES('$pro_id','$pro_qty','$d_comment','$cus_name','$d_address','$email','$tp_no','$today','PRE','$total_pro_cost','$discount')";
        // $conn->query($sql);
        if ($conn->query($sql_order) === TRUE) {
            $order_id = $conn->insert_id;
            foreach ($sql_ord_prop as $sql_property_value) {
                $sql_property_value = str_replace("#", "$order_id", $sql_property_value);
                if ($conn->query($sql_property_value) == true) {
                    echo"<div class='alert alert-success'>Registration is done..!</div>";
                } else {
                    echo "Error: " . $sql_property_value . "<br>" . $conn->error;
                }
            }
            foreach ($sql_ord_acc as $sql_acc_value) {
                $sql_acc_value = str_replace("#", "$order_id", $sql_acc_value);
                if ($conn->query($sql_acc_value) == true) {
                    echo"<div class='alert alert-success'>Registration is done..!</div>";
                } else {
                    echo "Error: " . $sql_acc_value . "<br>" . $conn->error;
                }
            }






            echo"<div class='alert alert-success'>Order send successfully..!</div>";
//        echo $msg = json_encode($x);
//            echo "New record created successfully. Last inserted ID is: " . $order_id;
            include 'email/mail.php';
            $body = " <!doctype html>
<html>
  <head>
    <meta name='viewport' content='width=device-width' />
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>Simple Transactional Email</title>
    <style>
      /* -------------------------------------
          GLOBAL RESETS
      ------------------------------------- */
      
      /*All the styling goes here*/
      
      img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%; 
      }

      body {
        background-color: #f6f6f6;
        font-family: sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 0;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%; 
      }

      table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
        table td {
          font-family: sans-serif;
          font-size: 14px;
          vertical-align: top; 
      }

      /* -------------------------------------
          BODY & CONTAINER
      ------------------------------------- */

      .body {
        background-color: #f6f6f6;
        width: 100%; 
      }

      /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
      .container {
        display: block;
        margin: 0 auto !important;
        /* makes it centered */
        max-width: 580px;
        padding: 10px;
        width: 580px; 
      }

      /* This should also be a block element, so that it will fill 100% of the .container */
      .content {
        box-sizing: border-box;
        display: block;
        margin: 0 auto;
        max-width: 580px;
        padding: 10px; 
      }

      /* -------------------------------------
          HEADER, FOOTER, MAIN
      ------------------------------------- */
      .main {
        background: #ffffff;
        border-radius: 3px;
        width: 100%; 
      }

      .wrapper {
        box-sizing: border-box;
        padding: 20px; 
      }

      .content-block {
        padding-bottom: 10px;
        padding-top: 10px;
      }

      .footer {
        clear: both;
        margin-top: 10px;
        text-align: center;
        width: 100%; 
      }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 12px;
          text-align: center; 
      }

      /* -------------------------------------
          TYPOGRAPHY
      ------------------------------------- */
      h1,
      h2,
      h3,
      h4 {
        color: #000000;
        font-family: sans-serif;
        font-weight: 400;
        line-height: 1.4;
        margin: 0;
        margin-bottom: 30px; 
      }

      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize; 
      }

      p,
      ul,
      ol {
        font-family: sans-serif;
        font-size: 14px;
        font-weight: normal;
        margin: 0;
        margin-bottom: 15px; 
      }
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 5px; 
      }

      a {
        color: #3498db;
        text-decoration: underline; 
      }

      /* -------------------------------------
          BUTTONS
      ------------------------------------- */
      .btn {
        box-sizing: border-box;
        width: 100%; }
        .btn > tbody > tr > td {
          padding-bottom: 15px; }
        .btn table {
          width: auto; 
      }
        .btn table td {
          background-color: #ffffff;
          border-radius: 5px;
          text-align: center; 
      }
        .btn a {
          background-color: #ffffff;
          border: solid 1px #3498db;
          border-radius: 5px;
          box-sizing: border-box;
          color: #3498db;
          cursor: pointer;
          display: inline-block;
          font-size: 14px;
          font-weight: bold;
          margin: 0;
          padding: 12px 25px;
          text-decoration: none;
          text-transform: capitalize; 
      }

      .btn-primary table td {
        background-color: #3498db; 
      }

      .btn-primary a {
        background-color: #3498db;
        border-color: #3498db;
        color: #ffffff; 
      }

      /* -------------------------------------
          OTHER STYLES THAT MIGHT BE USEFUL
      ------------------------------------- */
      .last {
        margin-bottom: 0; 
      }

      .first {
        margin-top: 0; 
      }

      .align-center {
        text-align: center; 
      }

      .align-right {
        text-align: right; 
      }

      .align-left {
        text-align: left; 
      }

      .clear {
        clear: both; 
      }

      .mt0 {
        margin-top: 0; 
      }

      .mb0 {
        margin-bottom: 0; 
      }

      .preheader {
        color: transparent;
        display: none;
        height: 0;
        max-height: 0;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        mso-hide: all;
        visibility: hidden;
        width: 0; 
      }

      .powered-by a {
        text-decoration: none; 
      }

      hr {
        border: 0;
        border-bottom: 1px solid #f6f6f6;
        margin: 20px 0; 
      }

      /* -------------------------------------
          RESPONSIVE AND MOBILE FRIENDLY STYLES
      ------------------------------------- */
      @media only screen and (max-width: 620px) {
        table[class=body] h1 {
          font-size: 28px !important;
          margin-bottom: 10px !important; 
        }
        table[class=body] p,
        table[class=body] ul,
        table[class=body] ol,
        table[class=body] td,
        table[class=body] span,
        table[class=body] a {
          font-size: 16px !important; 
        }
        table[class=body] .wrapper,
        table[class=body] .article {
          padding: 10px !important; 
        }
        table[class=body] .content {
          padding: 0 !important; 
        }
        table[class=body] .container {
          padding: 0 !important;
          width: 100% !important; 
        }
        table[class=body] .main {
          border-left-width: 0 !important;
          border-radius: 0 !important;
          border-right-width: 0 !important; 
        }
        table[class=body] .btn table {
          width: 100% !important; 
        }
        table[class=body] .btn a {
          width: 100% !important; 
        }
        table[class=body] .img-responsive {
          height: auto !important;
          max-width: 100% !important;
          width: auto !important; 
        }
      }

      /* -------------------------------------
          PRESERVE THESE STYLES IN THE HEAD
      ------------------------------------- */
      @media all {
        .ExternalClass {
          width: 100%; 
        }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
          line-height: 100%; 
        }
        .apple-link a {
          color: inherit !important;
          font-family: inherit !important;
          font-size: inherit !important;
          font-weight: inherit !important;
          line-height: inherit !important;
          text-decoration: none !important; 
        }
        #MessageViewBody a {
          color: inherit;
          text-decoration: none;
          font-size: inherit;
          font-family: inherit;
          font-weight: inherit;
          line-height: inherit;
        }
        .btn-primary table td:hover {
          background-color: #34495e !important; 
        }
        .btn-primary a:hover {
          background-color: #34495e !important;
          border-color: #34495e !important; 
        } 
      }

    </style>
  </head>
  <body >
    <span class='preheader'>This is preheader text. Some clients will show this text as a preview.</span>
    <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
      <tr>
        <td>&nbsp;</td>
        <td class='container'>
          <div class='content'>

            <!-- START CENTERED WHITE CONTAINER -->
            <table role='presentation' class='main'>

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class='wrapper'>
                  <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                    <tr>
                      <td>
                        <p>Hi $cus_name,</p>
                        <h4>Thank you for your order !</h4>
                        <p>Order Id : $order_id</p>
                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary'>
                          <tbody>
                            <tr>
                              <td align='left'>
                                <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                  <tbody>
                                    <tr>
                                      
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                         <p>Total Material cost                   : Rs." . round(sales_material_cost($tot_material_cost), 2) . "</p
                         <p>Total Service cost                    : Rs." . round($tot_service_cost, 2) . "</p>
                            
                                 
                            ";
            if (discount($pro_id) != 0) {
                $body .= "<p>Grand Total : Rs." . $total_pro_cost . " </p>"
                        . "<p> Discount of (" . discount($pro_id) . " %) : Rs." . $discount . "</p>"
                        . "<p>NET total                                : Rs." . $final_cost . " </p>";
            } else {
                $body .= "<p>NET total                                : Rs." . $final_cost . " </p>";
            }

            $body .= "    
                         
                            

                        <p>Please visit our outdoor shop with Rs. " . round($final_cost / 2, 2) . " (half of the Production Cost as an advance payment) to conferm your order.</p>
                        <p>This quatation valid for  weeks only.</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>
            <!-- END CENTERED WHITE CONTAINER -->

            <!-- START FOOTER -->
            <div class='footer'>
              <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                <tr>
                  <td class='content-block'>
                    <span class='apple-link'>The D Ads Digital , No:10/B, Sri Somananda Mawatha, Horana.</span>
                   
                  </td>
                </tr>
                <tr>
                  <td class='content-block powered-by'>
                    
                  </td>
                </tr>
              </table>
            </div>
            <!-- END FOOTER -->

          </div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>
</html> ";
            $title = pro_name($pro_id) . " Pre-Order";
            send_mail("$email", "The D Ads Digital and Offset Printers", $title, $body);
        } else {
             "Error: " . $sql_order . "<br>" . $conn->error;
        }
    } else {


        echo "<div class='alert alert-danger'>Pre-Order unsuccessful..!</div>";
    }
}
?>

