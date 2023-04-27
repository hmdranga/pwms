<?php

include 'helper.php';
include 'conn.php';
//echo $_POST['paper_size'];
//print_r($_POST);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //define variable for common variables
    $pro_id = $pro_qty = $product_cost = null;

    //assign value
    $pro_id = clean_input($_POST['pro_id']);
    $pro_qty = clean_input($_POST['pro_qty']);

    //define variable for error control
    $x[] = null;
    $e = 1;

    //empty validation----------------------------------------------------------
    if (empty($pro_qty)) {
        $x['pro_qty'] = "<div class='alert alert-danger'>Product quantity should not be empty...!</div>";
        $e = 0;
    }
    //end empty validation------------------------------------------------------
    //Advanced validation-------------------------------------------------------
    if (!empty($pro_qty)) {
        // invalid 
        if (!is_numeric($pro_qty)) {

            $x['pro_qty'] = "<div class='alert alert-danger'>The product quantity should be number...!</div>";
            $e = 0;
        }
        // product qty should be positive number
        if ($pro_qty <= 0) {
            $x['pro_qty'] = "<div class='alert alert-danger'>The product quantity should be positive number...!</div>";
            $e = 0;
        }
    }
    //end advanced validation---------------------------------------------------
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
            $inr_print = clean_input($_POST['inner_print#20']);
            $pages = clean_input($_POST['pages#5']);
            $print_side = clean_input($_POST['printing_side#12']);
            $cvr_ppr_thick = clean_input($_POST['cover_paper_thick#8']);
            $cvr_print = clean_input($_POST['cover_print#21']);
            $cvr_laminate = clean_input($_POST['laminate_type#13']);
            $binding = clean_input($_POST['binding#10']);
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
            
            $innr_ppr_cost = ($innr_ppr_qty * avlable_itm_max_price(1, $act_ppr_size, $ppr_thick, $ppr_color) * $pro_qty);
          
            
            
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
//end cover paper cost----------------------------------------------------------

// 3 inner ink cost calculation-------------------------------------------------
            $innr_color_type = $innr_print_type = null;

            if ($pro_qty < 500) {

                $innr_print_type = 150; // digital print
                $serface = 2.1; //count of ml per squre meter for digital print
                if ($inr_print == 66) {// 1/1 black
                    // black
                    $innr_color_type = 46;
                    // price for black ink 
                    $inr_ink_unit_price = avlable_itm_max_price(5, $innr_color_type, $innr_print_type);
                } elseif ($inr_print == 67) {// 4/4 cmyk
                    // price for all 4 colors 
                    for ($innr_color_type = 43; $innr_color_type <= 46; $innr_color_type++) {
                        $inr_ink_unit_price += avlable_itm_max_price(5, $innr_color_type, $innr_print_type);
                    }
                }
            } else {
                $innr_print_type = 149; // offset print
                $serface = 0.9; //count of ml per squre meter foor offset print
                if ($inr_print == 66) {// 1/1 black
                    $innr_color_type = 46;
                    // price for black ink 
                    echo "inner ink unit cost " . $inr_ink_unit_price = avlable_itm_max_price(5, $innr_color_type, $innr_print_type) . "                               ";
                    //
                } elseif ($inr_print == 67) {// 4/4 cmyk
                    // price for all 4 colors 
                    for ($innr_color_type = 43; $innr_color_type <= 46; $innr_color_type++) {
                        echo "inner ink unit cost " . $inr_ink_unit_price += avlable_itm_max_price(5, $innr_color_type, $innr_print_type) . "                          ";
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
//end inner ink cost calculation------------------------------------------------

//4 cover print ink cost--------------------------------------------------------
            if ($pro_qty < 500) {
                $cvr_print_type = 150; // digital print
                $serface = 2.1; //count of ml per squre meter for digital print
                if ($cvr_print == 65) {// 1/1 black                    
                    $cvr_color_type = 46;// black                    
                    $cvr_ink_unit_price = avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);// price for black ink 
                } elseif ($cvr_print == 64) {// 4/4 cmyk
                    // price for all 4 colors 
                    for ($cvr_color_type = 43; $cvr_color_type <= 46; $cvr_color_type++) {
                        $cvr_ink_unit_price += avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                    }
                }
            } else {
                $cvr_print_type = 149; // offset print
                $serface = 0.9; //count of ml per squre meter foor offset print
                if ($cvr_print == 65) {// 1/1 black
                    $cvr_color_type = 46;//black
                    // price for black ink 
                    $cvr_ink_unit_price = avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                } elseif ($cvr_print == 64) {// 4/4 cmyk
                    // price for all 4 colors 
                    for ($cvr_color_type = 43; $cvr_color_type <= 46; $cvr_color_type++) {
                        avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                        $cvr_ink_unit_price += avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                    }
                }
            }
            // total cover ink cost
            $cvr_ink_cost = $cvr_width * $cvr_length * $cvr_ink_unit_price * $pro_qty * $serface / 1000000;
//end cover print ink cost------------------------------------------------------

//5 laminte paper---------------------------------------------------------------

            if ($cvr_laminate != 6) {// not non laminate type
//                laminate  price 
                $laminate_cost = $cvr_length * avlable_itm_max_price(10, $cvr_width_id, $cvr_laminate) * $pro_qty;
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
                //comb bind price 
                $bind_cost = avlable_itm_max_price(9, $comp_diameter, prop_val_to_id(($cvr_length / 2))) * $pro_qty;
            } elseif ($binding == 13) { //perfect bind 
                if ($innr_ppr_qty % 8 == 0) {
                    $wool_count = $innr_ppr_qty / 8;
                } else {
                    $wool_count = floor($innr_ppr_qty / 8) + 1;
                }
                $wool_mat = 159; //nylon
                $wool_color = 143; // white
                echo "wool cost " . $wool_cost = avlable_itm_max_price(15, $wool_mat, $wool_color) * $cvr_width * $pro_qty * $wool_count;
                echo "glue cost " . $glue_stick_cost = avlable_itm_max_price(7, $cvr_width_id) * $thick * $pro_qty;
                $bind_cost = $glue_stick_cost + $wool_cost;
            } elseif ($binding == 63) {// sndlestich bind
                $sql = "SELECT * FROM `tb_product_property_value` where property_id = 24 AND value >= $thick ORDER BY `tb_product_property_value`.`value` ASC LIMIT 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $comp_diameter = $row['property_value_id'];
                }
                $bind_cost = avlable_itm_max_price(4, $comp_diameter) * 2 * $pro_qty;
            }
            //total material cost 
            $tot_material_cost = $innr_ppr_cost + $cvr_ppr_cost + $innr_ink_cost + $cvr_ink_cost + $laminate_cost + $bind_cost;
            // sales price of item 30% added to actual cost
//            echo "Total Cost Of Inner Paper(" . pro_id_to_val($act_ppr_size) . " x " . $innr_ppr_qty . " Sheets  x Quantity of " . $pro_qty . ") : " . sales_material_cost($innr_ppr_cost);
//            echo "Total Cost Cover Paper (Width " . $cvr_width . "(mm) x Length " . $cvr_length . "(mm) x Quantity of " . $pro_qty . ")  : " . $cvr_ppr_cost;
//
//            echo "Total Ink Cost For Inner Print ( Width " . $width . "(mm) x Length " . $length . "(mm) " . $pages . " pages x Quantity of " . $pro_qty . ") : " . sales_material_cost($innr_ink_cost);
//
//            echo "Total Ink Cost For Cover Print (Width " . $cvr_width . "(mm) x Length " . $cvr_length . "(mm) x Quantity of " . $pro_qty . ") : " . sales_material_cost($cvr_ink_cost);
//
//            echo "Total Cost Of Cover Laminate(" . $cvr_width . "(mm) x " . $cvr_length . "(mm) x Quantity of " . $pro_qty . ") : " . sales_material_cost($laminate_cost);
//
//            $bind = null;
//            $bind .= "Total Cost Of Binding Materials(";
//            if ($binding == 14) {
//                $bind .= "Plastick Comb Width(mm) " . $cvr_length / 2 . " x Diameter(mm) " . pro_id_to_val($comp_diameter);
//            } elseif ($binding == 13) {
//                $bind .= "Nylon White Colour Wool Length " . $wool_count * $cvr_width . "(mm) And ";
//                $bind .= "Glue stick $cvr_width_id (mm) x $thick (mm) ";
//            } elseif ($binding == 63) {
//                $bind .= "Staple leg length " . pro_id_to_val($comp_diameter) . " (mm) x 2 ";
//            }
//            echo $bind .= "x Quantity of " . $pro_qty . ") : " . sales_material_cost($bind_cost);

            echo"Total Cost Of Materials : " . round(sales_material_cost($tot_material_cost), 2);
// service cost-----------------------------------------------------------------
//01 cover design---------------------------------------------------------------
            echo "task cost of designing :" . $design_cost = task_cost(7, $cvr_width * $cvr_length);
//02 typing---------------------------------------------------------------------
            echo "task cost of typing :" . $typing_cost = task_cost(6, $width * $length * $pages);
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
            echo "task cost of cover print :" . $cvr_print_cost;
//04 inner print----------------------------------------------------------------
            echo "inner print type " . $inr_print;
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
            echo "task cost of inner print :" . $innr_print_cost;
//            echo"cover width :" . $cvr_width . " cover length :" . $cvr_length;
//05 cover laminate-------------------------------------------------------------
            echo "task cost of laminating :" . $laminating_cost = task_cost(5, $cvr_width * $cvr_length * $pro_qty);
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

            echo "task cost of Binding :" . $binding_cost;
//07 die cutting----------------------------------------------------------------
            echo "task cost of Die cutting :" . $die_cutting_cost = task_cost(4, $pro_qty);
//end task cost-----------------------------------------------------------------
            // view quatation 
            $tot_service_cost = $design_cost + $typing_cost + $cvr_print_cost + $innr_print_cost + $laminating_cost + $binding_cost;
            echo"Total Cost Of Service : " . round($tot_service_cost, 2);
            echo"Total Production cost : " . (round($tot_service_cost, 2) + round($tot_material_cost * 1.3, 2));

            break;
//-----------------------------Book---------------------------------------------
        case 2:    
            // define variable 
            $cvr_ink_unit_price = $inr_ink_unit_price = $innr_ppr_qty = $ppr_size = $act_ppr_size = $ppr_thick = $ppr_color = $inr_print = $pages = $print_side = $cvr_ppr_thick = $cvr_laminate = $binding = null;
            //assign values-----------------------------------------------------
            $ppr_size = clean_input($_POST['paper_size#1']);
            $ppr_thick = clean_input($_POST['paper_thick#7']);
            $ppr_color = clean_input($_POST['paper_colour#2']);
            $inr_print = clean_input($_POST['inner_print#20']);

            $pages = clean_input($_POST['pages#5']);
            $print_side = clean_input($_POST['printing_side#12']);
            $cvr_ppr_thick = clean_input($_POST['cover_paper_thick#8']);
            $cvr_print = clean_input($_POST['cover_print#21']);
            $cvr_laminate = clean_input($_POST['laminate_type#13']);
            $binding = clean_input($_POST['binding#10']);
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
            $innr_ppr_cost = ($innr_ppr_qty * avlable_itm_max_price(1, $act_ppr_size, $ppr_thick, $ppr_color) * $pro_qty);
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

//end cover paper cost----------------------------------------------------------
// 3 inner ink cost calculation-------------------------------------------------
            $innr_color_type = $innr_print_type = null;

            if ($pro_qty < 500) {
                $innr_print_type = 150; // digital print
                $serface = 2.1; //count of ml per squre meter for digital print
                if ($inr_print == 66) {// 1/1 black
                    // black
                    $innr_color_type = 46;
                    // price for black ink 
                    $inr_ink_unit_price = avlable_itm_max_price(5, $innr_color_type, $innr_print_type);
                } elseif ($inr_print == 67) {// 4/4 cmyk
                    // price for all 4 colors 
                    for ($innr_color_type = 43; $innr_color_type <= 46; $innr_color_type++) {
                        $inr_ink_unit_price += avlable_itm_max_price(5, $innr_color_type, $innr_print_type);
                    }
                }
            } else {
                $innr_print_type = 149; // offset print
                $serface = 0.9; //count of ml per squre meter foor offset print
                if ($inr_print == 66) {// 1/1 black
                    $innr_color_type = 46;
                    // price for black ink 
                    $inr_ink_unit_price = avlable_itm_max_price(5, $innr_color_type, $innr_print_type);
                    //
                } elseif ($inr_print == 67) {// 4/4 cmyk
                    // price for all 4 colors 
                    for ($innr_color_type = 43; $innr_color_type <= 46; $innr_color_type++) {
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

//end inner ink cost calculation------------------------------------------------
//4 cover print ink cost--------------------------------------------------------
            if ($pro_qty < 500) {
                $cvr_print_type = 150; // digital print
                $serface = 2.1; //count of ml per squre meter for digital print
                if ($cvr_print == 65) {// 1/1 black
                    $cvr_color_type = 46;// black
                    // price for black ink 
                    $cvr_ink_unit_price = avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                } elseif ($cvr_print == 64) {// 4/4 cmyk
                    // price for all 4 colors 
                    for ($cvr_color_type = 43; $cvr_color_type <= 46; $cvr_color_type++) {
                        $cvr_ink_unit_price += avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                    }
                }
            } else {
                $cvr_print_type = 149; // offset print
                $serface = 0.9; //count of ml per squre meter foor offset print
                if ($cvr_print == 66) {// 1/1 black
                    $cvr_color_type = 46;
                    // price for black ink 
                    $cvr_ink_unit_price = avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                } elseif ($cvr_print == 67) {// 4/4 cmyk
                    // price for all 4 colors 
                    for ($cvr_color_type = 43; $cvr_color_type <= 46; $cvr_color_type++) {
                        $cvr_ink_unit_price += avlable_itm_max_price(5, $cvr_color_type, $cvr_print_type);
                    }
                }
            }
            //total cover ink cost
            $cvr_ink_cost = $cvr_width * $cvr_length * $pro_qty * $serface * $cvr_ink_unit_price / 1000000;

//end cover print ink cost------------------------------------------------------
//5 laminte paper---------------------------------------------------------------

            if ($cvr_laminate != 6) {// not non laminate type
                // laminate  price formula
                $laminate_cost = $cvr_length * avlable_itm_max_price(10, $cvr_width_id, $cvr_laminate) * $pro_qty;
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

                //comb bind price 
                echo "bind cost " . $bind_cost = avlable_itm_max_price(9, $comp_diameter, prop_val_to_id(($cvr_length / 2))) * $pro_qty;
            } elseif ($binding == 13) { //perfect bind 
                if ($innr_ppr_qty % 8 == 0) {
                    $wool_count = $innr_ppr_qty / 8;
                } else {
                    $wool_count = floor($innr_ppr_qty / 8) + 1;
                }
                $wool_mat = 159; //nylon
                $wool_color = 143; // white

                $wool_cost = avlable_itm_max_price(15, $wool_mat, $wool_color) * $cvr_width * $pro_qty * $wool_count;
                $glue_stick_cost = avlable_itm_max_price(7, $cvr_width_id) * $thick * $pro_qty;
                $bind_cost = $glue_stick_cost + $wool_cost;
            } elseif ($binding == 63) {// sndlestich bind
                $sql = "SELECT * FROM `tb_product_property_value` where property_id = 24 AND value >= $thick ORDER BY `tb_product_property_value`.`value` ASC LIMIT 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    $row = $result->fetch_assoc();
                    $comp_diameter = $row['property_value_id'];
                }
                $bind_cost = avlable_itm_max_price(4, $comp_diameter) * 2 * $pro_qty;
            }
//end binding cost--------------------------------------------------------------
//Total Cost of material--------------------------------------------------------
            //total material cost 
            $tot_material_cost = $innr_ppr_cost + $cvr_ppr_cost + $innr_ink_cost + $cvr_ink_cost + $laminate_cost + $bind_cost;
            // sales price of item 30% added to actual cost
            echo "Total Cost Of Inner Paper(" . pro_id_to_val($act_ppr_size) . " x " . $innr_ppr_qty . " Sheets  x Quantity of " . $pro_qty . ") : " . sales_material_cost($innr_ppr_cost);

            echo "<br> Total Cover Paper (Width " . $cvr_width . "(mm) x Length " . $cvr_length . "(mm) x Quantity of " . $pro_qty . ")  : " . sales_material_cost($cvr_ppr_cost);

            echo "Total Ink Cost For Inner Print ( Width " . $width . "(mm) x Length " . $length . "(mm) " . $pages . " pages x Quantity of " . $pro_qty . ") : " . sales_material_cost($innr_ink_cost);

            echo "Total Ink Cost For Cover Print (Width " . $cvr_width . "(mm) x Length " . $cvr_length . "(mm) x Quantity of " . $pro_qty . ") : " . sales_material_cost($cvr_ink_cost);

            echo "Total Cost Of Cover Laminate(" . $cvr_width . "(mm) x " . $cvr_length . "(mm) x Quantity of " . $pro_qty . ") : " . sales_material_cost($laminate_cost);

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
            echo $bind .= " Quantity of " . $pro_qty . ") : " . sales_material_cost($bind_cost);

            echo"Total Cost Of Materials : " . round(sales_material_cost($tot_material_cost), 2);
//end total material cost-------------------------------------------------------
// service cost--------------------------------------------------------------------
//01 cover design---------------------------------------------------------------
            echo "task cost of designing :" . $design_cost = task_cost(7, $cvr_width * $cvr_length);
//02 typing---------------------------------------------------------------------
            echo "task cost of typing :" . $typing_cost = task_cost(6, $width * $length * $pages);
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
            echo "task cost of cover print :" . $cvr_print_cost;
//04 inner print----------------------------------------------------------------
            echo "inner print type " . $inr_print;
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
            echo "task cost of inner print :" . $innr_print_cost;
//            echo"cover width :" . $cvr_width . " cover length :" . $cvr_length;
//05 cover laminating-------------------------------------------------------------
            if ($cvr_laminate != 6) {// not non laminate type
                echo "task cost of laminating :" . $laminating_cost = task_cost(5, $cvr_width * $cvr_length * $pro_qty);
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

            echo "task cost of Binding :" . $binding_cost;
//07 die cutting----------------------------------------------------------------
            echo "task cost of Die cutting :" . $die_cutting_cost = task_cost(4, $pro_qty);


            $tot_service_cost = $design_cost + $typing_cost + $cvr_print_cost + $innr_print_cost + $laminating_cost + $binding_cost;
            echo"Total Cost Of Service : " . round($tot_service_cost, 2);
            echo"Total Production cost : " . (round($tot_service_cost, 2) + round(sales_material_cost($tot_material_cost), 2));
            echo"cover paper cost " . sales_material_cost($laminate_cost + $cvr_ppr_cost + $cvr_ink_cost);
            echo"print " . $cvr_print_cost;
            echo"laminate " . $laminating_cost;

//end task cost-----------------------------------------------------------------
            break;
//-------------------------poster-----------------------------------------------
        case 3: 
            //define variable
            $ppr_size = $ppr_color = $ppr_thick = $ink_unit_price = $print = $laminate = $ppr_cost = $print_type = $ink_cost = $length = $width = $serface = $width_id = null;
            //Asign value
            $ppr_size = clean_input($_POST['paper_size#1']);
            $ppr_thick = clean_input($_POST['paper_thick#7']);
            $ppr_color = clean_input($_POST['paper_colour#2']);
            $print = clean_input($_POST['print#37']);
            $laminate = clean_input($_POST['laminate_type#13']);
            $print_type = 149; //offset print
            $serface = 0.9; // offset serface of print
//1 paper-----------------------------------------------------------------------            
            //paper cost
            $ppr_cost = ( avlable_itm_max_price(1, $ppr_size, $ppr_thick, $ppr_color) * $pro_qty);
//end paper---------------------------------------------------------------------
//2 ink ------------------------------------------------------------------------
            if ($print == 161) {// color 1/1 black
                $color_type = 46; // black
                echo $ink_unit_price = avlable_itm_max_price(5, $color_type, $print_type);
            } elseif ($print == 162) {//color 4/4 cmyk
                // price for all 4 colors 
                for ($color_type = 43; $color_type <= 46; $color_type++) {
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

            echo $ink_cost = $ink_unit_price * $pro_qty * $length * $width * $serface / 1000000;
//end ink-----------------------------------------------------------------------
//laminate----------------------------------------------------------------------
            if ($laminate != 6) {
                $sql = "SELECT `property_value_id` FROM `tb_product_property_value` WHERE  value = $width AND property_id = 22";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $width_id = $row['property_value_id'];
                }
            } else {
                $laminate_cost = 0;
            }
            echo "laminate  " . $laminate_cost = avlable_itm_max_price(10, $width_id, $laminate) * $pro_qty * $length;
//end laminate------------------------------------------------------------------
//total quate for meterials-----------------------------------------------------
            $tot_material_cost = $ink_cost + $ppr_cost + $laminate_cost;
            // sales price of item 30% added to actual cost
            echo "Total Cost Of Paper(" . pro_id_to_val($ppr_size) . " x " . $pro_qty . " Sheets  ) : " . sales_material_cost($ppr_cost);

            echo "Total Ink Cost For Print ( Width " . $width . "(mm) x Length " . $length . "(mm)  Quantity of " . $pro_qty . ") : " . sales_material_cost($ink_cost);

            echo "Total Cost Of  Laminate (" . $width . "(mm) x " . $length . "(mm) x Quantity of " . $pro_qty . ") : " . sales_material_cost($laminate_cost);

            echo"Total Cost Of Materials : " . round(sales_material_cost($tot_material_cost), 2);

// service cost-----------------------------------------------------------------
//01 design---------------------------------------------------------------------
            echo "task cost of designing :" . $design_cost = task_cost(7, $width * $length);
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
            echo "task cost of laminating :" . $laminating_cost;
//04 diecutting-----------------------------------------------------------------
            if ($pro_qty % 50 == 0) {
                $die_cutting_cost = task_cost(4, $pro_qty / 50);
            } else {
                $die_cutting_cost = task_cost(4, floor($pro_qty / 50) + 1);
            }
            echo "task cost of die cutting :" . $die_cutting_cost;
// Total service cost ----------------------------------------------------------           
            $tot_service_cost = $design_cost + $print_cost + $laminating_cost + $die_cutting_cost;
            echo"Total Cost Of Service : " . round($tot_service_cost, 2);
//total production cost---------------------------------------------------------
            echo"Total Production cost : " . (round($tot_service_cost, 2) + round(sales_material_cost($tot_material_cost), 2));


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
            $print_side = clean_input($_POST['printing_side#12']);
            $ppr_thick = clean_input($_POST['cover_paper_thick#8']);
            $print = clean_input($_POST['print#37']);
            $laminate = clean_input($_POST['laminate_type#13']);
            $print_type = 149; //offset print
            $serface = 0.9; // offset serface of print
//1 paper-----------------------------------------------------------------------            
            $ppr_cost = avlable_itm_max_price(8, $width_id, $ppr_thick) * $length * $pro_qty;
//end paper---------------------------------------------------------------------
//2 ink ------------------------------------------------------------------------
            if ($print == 161) {// color 1/1 black
                $color_type = 46; // black
                echo $ink_unit_price = avlable_itm_max_price(5, $color_type, $print_type);
            } elseif ($print == 162) {//color 4/4 cmyk
                // price for all 4 colors 
                for ($color_type = 43; $color_type <= 46; $color_type++) {
                    $ink_unit_price += avlable_itm_max_price(5, $color_type, $print_type);
                }
            }
            if ($print_side == 8) {//single side
                echo $ink_cost = $ink_unit_price * $pro_qty * $length * $width * $serface / 1000000;
            } elseif ($print_side == 9) {// double side
                echo $ink_cost = $ink_unit_price * $pro_qty * $length * $width * $serface * 2 / 1000000;
            }
//end ink-----------------------------------------------------------------------

//laminate----------------------------------------------------------------------
            echo "laminate" . $laminate_cost = avlable_itm_max_price(10, $width_id, $laminate) * $pro_qty * $length;
//end laminate------------------------------------------------------------------
//total quate for meterials-----------------------------------------------------
            $tot_material_cost = $ink_cost + $ppr_cost + $laminate_cost;
            // sales price of item 30% added to actual cost
            echo "Total Cost Of Paper( Standerd Business Card size x " . $pro_qty . " Sheets  ) : " . sales_material_cost($ppr_cost);

            echo "Total Ink Cost For Print ( Width " . $width . "(mm) x Length " . $length . "(mm)  Quantity of " . $pro_qty . ") : " . sales_material_cost($ink_cost);

            echo "Total Cost Of  Laminate (" . $width . "(mm) x " . $length . "(mm) x Quantity of " . $pro_qty . ") : " . sales_material_cost($laminate_cost);

            echo"Total Cost Of Materials : " . round(sales_material_cost($tot_material_cost), 2);
//service cost------------------------------------------------------------------
//designing cost----------------------------------------------------------------            
            echo "task cost of designing :" . $design_cost = task_cost(7, $width * $length);
//printing----------------------------------------------------------------------
            $print_cost = task_cost(1, $width * $length * $pro_qty);
            if ($print == 162) {// color 4/4  cmyk
                $print_cost = $print_cost * 4;
            }
            echo "printing cost : " . $print_cost;
//laminating--------------------------------------------------------------------
            if ($laminate != 6) {// not non laminate type
                echo "task cost of laminating :" . $laminating_cost = task_cost(5, $width * $length * $pro_qty);
            } else {
                $laminating_cost = 0;
            }
            echo "laminatin cost : " . $laminating_cost;
//die cutting cost--------------------------------------------------------------
            if ($pro_qty % 25 == 0) {
                $die_cutting_cost = task_cost(4, $pro_qty / 25);
            } else {
                $die_cutting_cost = task_cost(4, floor($pro_qty / 25) + 1);
            }
            if ($shape != 28) {// standerd shape             
                $die_cutting_cost = $die_cutting_cost * 1.1;
            }


            echo "task cost of shape cutting :" . $die_cutting_cost;
//Total service cost of business card-------------------------------------------
            $tot_service_cost = $design_cost + $print_cost + $laminating_cost + $die_cutting_cost;
            echo"Total service cost :" . round($tot_service_cost);
            echo"Total Production cost : " . (round($tot_service_cost, 2) + round(sales_material_cost($tot_material_cost), 2));

            break;
//-----------------------------------mug----------------------------------------
        case 13:   
            //define variable
            $mug_vol = $mug_color = $print = $ink_unit_price = $height = $radious = null;
            //Asign value
            $mug_vol = clean_input($_POST['mug_volume#28']);
            $mug_color = clean_input($_POST['mug_colour#29']);
            $print = clean_input($_POST['print#37']);
            $serface = 1.5;

// 1 mug------------------------------------------------------------------------
            $mug_cost = avlable_itm_max_price(11, $mug_vol, $mug_color) * $pro_qty;
//end mug-----------------------------------------------------------------------

//2 sublimation paper-----------------------------------------------------------       
            // mug height
            $sql = "SELECT * FROM `tb_sub_property_value` where property_value_id = $mug_vol AND property_id = 23";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo"height" . $height = $row['value'];

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
                echo"dddddddddd" . $mug_diameter = $row['value'];
            }
            
            $ppr_cost = avlable_itm_max_price(13, $height_id) * $mug_diameter * pi() * $pro_qty;
//end sublimation paper---------------------------------------------------------

//3 sublimation ink-------------------------------------------------------------
//colourtype
            if ($print == 161) {// color 1/1 black
                $color_type = 46; // black
                $ink_unit_price = avlable_itm_max_price(12, $color_type);
            } elseif ($print == 162) {//color 4/4 cmyk
                // price for all 4 colors 
                for ($color_type = 43; $color_type <= 46; $color_type++) {
                    $ink_unit_price += avlable_itm_max_price(5, $color_type);
                }
            }
            echo"ink cost" . $ink_cost = $ink_unit_price * ink_qty($mug_diameter * pi() * $height, $serface) * $pro_qty;
//end sublimation ink-----------------------------------------------------------
//total quate for meterials-----------------------------------------------------
            $tot_material_cost = $ink_cost + $ppr_cost + $mug_cost;
            // sales price of item 30% added to actual cost
            echo "Total Cost Of Mug" . pro_id_to_val($mug_vol) . " x " . $pro_qty . " Mugs ) : " . sales_material_cost($mug_cost);
            echo "Total Cost Of Paper( sublimation paper width : " . $height . "(mm) x length (mm)" . round(pi() * $mug_diameter, 2) . " Quantity of " . $pro_qty . " Sheets  ) : " . sales_material_cost($ppr_cost);
            echo "Total Ink Cost For Print ( Height " . $height . "(mm) x Deiameter " . round(pi() * $mug_diameter, 2) . "(mm)  Quantity of " . $pro_qty . ") : " . sales_material_cost($ink_cost);
            echo"Total Cost Of Materials : " . round(sales_material_cost($tot_material_cost), 2);

//service cost------------------------------------------------------------------
//
//designing cost----------------------------------------------------------------            
            echo "task cost of designing :" . $design_cost = task_cost(7, $mug_diameter * pi() * $height);
//printing----------------------------------------------------------------------
            $print_cost = task_cost(10, $mug_diameter * pi() * $height * $pro_qty);
            if ($print == 162) {// color 4/4  cmyk
                $print_cost = $print_cost * 4;
            }
            echo "printing cost : " . $print_cost;

//Total service cost of business card-------------------------------------------
            $tot_service_cost = $design_cost + $print_cost;
            echo"Total service cost :" . round($tot_service_cost);
            echo"Total Production cost : " . (round($tot_service_cost, 2) + round(sales_material_cost($tot_material_cost), 2));

            break;
//------------------------------letterhead--------------------------------------
        case 16:   
            //define variable
            $ppr_size = $ppr_color = $ppr_thick = $ink_unit_price = $print = $ppr_cost = $print_type = $ink_cost = $length = $width = $serface = $width_id = null;
            //Asign value
            $ppr_size = clean_input($_POST['paper_size#1']);
            $ppr_thick = clean_input($_POST['paper_thick#7']);
            $ppr_color = clean_input($_POST['paper_colour#2']);
            $print = clean_input($_POST['print#37']);

            $print_type = 149; //offset print
            $serface = 0.9; // offset serface of print
//1 paper-----------------------------------------------------------------------            
            //paper cost
            $ppr_cost = ( avlable_itm_max_price(1, $ppr_size, $ppr_thick, $ppr_color) * $pro_qty);
//end paper---------------------------------------------------------------------
//2 ink ------------------------------------------------------------------------
            if ($print == 161) {// color 1/1 black
                $color_type = 46; // black
                $ink_unit_price = avlable_itm_max_price(5, $color_type, $print_type);
            } elseif ($print == 162) {//color 4/4 cmyk
                // price for all 4 colors 
                for ($color_type = 43; $color_type <= 46; $color_type++) {
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

            echo $ink_cost = $ink_unit_price * $pro_qty * $length * $width * $serface / 1000000;
//end ink-----------------------------------------------------------------------
//total quate for meterials-----------------------------------------------------
            $tot_material_cost = $ink_cost + $ppr_cost;
            // sales price of item 30% added to actual cost
            echo "Total Cost Of Paper(" . pro_id_to_val($ppr_size) . " x " . $pro_qty . " Sheets  ) : " . sales_material_cost($ppr_cost);

            echo "Total Ink Cost For Print ( Width " . $width . "(mm) x Length " . $length . "(mm)  Quantity of " . $pro_qty . ") : " . sales_material_cost($ink_cost);

            echo"Total Cost Of Materials : " . round(sales_material_cost($tot_material_cost), 2);
            
// service cost-----------------------------------------------------------------
//01 design---------------------------------------------------------------------
            echo "task cost of designing :" . $design_cost = task_cost(7, $width * $length);
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
            echo "task cost of die cutting :" . $die_cutting_cost;
// Total service cost ----------------------------------------------------------           
            $tot_service_cost = $design_cost + $print_cost + $laminating_cost + $die_cutting_cost;
            echo"Total Cost Of Service : " . round($tot_service_cost, 2);
//total production cost---------------------------------------------------------
            echo"Total Production cost : " . (round($tot_service_cost, 2) + round(sales_material_cost($tot_material_cost), 2));


            break;
//----------------------------invitation----------------------------------------
        case 17:  
            //define variable
            $ppr_size = $ppr_color = $ppr_thick = $ink_unit_price = $print = $laminate = $ppr_cost = $print_type = $ink_cost = $length = $width = $serface = $width_id = null;
            //Asign value
            $ppr_size = clean_input($_POST['paper_size#1']);
            $ppr_thick = clean_input($_POST['cover_paper_thick#8']);
            $print = clean_input($_POST['print#37']);
            $laminate = clean_input($_POST['laminate_type#13']);
            $print_type = 149; //offset print
            $serface = 0.9; // offset serface of print
            
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
            $ppr_cost = avlable_itm_max_price(8, $width_id, $ppr_thick) * $length * $pro_qty;
//end paper---------------------------------------------------------------------
//2 ink ------------------------------------------------------------------------
            if ($print == 161) {// color 1/1 black
                $color_type = 46; // black
                echo $ink_unit_price = avlable_itm_max_price(5, $color_type, $print_type);
            } elseif ($print == 162) {//color 4/4 cmyk
                // price for all 4 colors 
                for ($color_type = 43; $color_type <= 46; $color_type++) {
                    $ink_unit_price += avlable_itm_max_price(5, $color_type, $print_type);
                }
            }
            echo $ink_cost = $ink_unit_price * $pro_qty * $length * $width * $serface / 1000000;
//end ink-----------------------------------------------------------------------
//laminate----------------------------------------------------------------------
            echo "laminate" . $laminate_cost = avlable_itm_max_price(10, $width_id, $laminate) * $pro_qty * $length;
//end laminate------------------------------------------------------------------
//total quate for meterials-----------------------------------------------------
            $tot_material_cost = $ink_cost + $ppr_cost + $laminate_cost;
            // sales price of item 30% added to actual cost
            echo "Total Cost Of Paper(" . pro_id_to_val($ppr_size) . "x " . $pro_qty . " Sheets  ) : " . $ppr_cost * 1.3;

            echo "Total Ink Cost For Print ( Width " . $width . "(mm) x Length " . $length . "(mm)  Quantity of " . $pro_qty . ") : " . $ink_cost * 1.3;

            echo "Total Cost Of  Laminate (" . $width . "(mm) x " . $length . "(mm) x Quantity of " . $pro_qty . ") : " . $laminate_cost * 1.3;

            echo"Total Cost Of Materials : " . round($tot_material_cost * 1.3, 2);

//service cost------------------------------------------------------------------
//
//designing cost----------------------------------------------------------------            
            echo "task cost of designing :" . $design_cost = task_cost(7, $width * $length);
//printing----------------------------------------------------------------------
            $print_cost = task_cost(1, $width * $length * $pro_qty);
            if ($print == 162) {// color 4/4  cmyk
                $print_cost = $print_cost * 4;
            }
            echo "printing cost : " . $print_cost;
//laminating--------------------------------------------------------------------
            if ($laminate != 6) {// not non laminate type
                echo "task cost of laminating :" . $laminating_cost = task_cost(5, $width * $length * $pro_qty);
            } else {
                $laminating_cost = 0;
            }
            echo "laminatin cost : " . $laminating_cost;
//die cutting cost--------------------------------------------------------------
            if ($pro_qty % 50 == 0) {
                $die_cutting_cost = task_cost(4, $pro_qty / 50);
            } else {
                $die_cutting_cost = task_cost(4, floor($pro_qty / 50) + 1);
            }
            echo "task cost of shape cutting :" . $die_cutting_cost;
//Total service cost of invitation card-------------------------------------------
            $tot_service_cost = $design_cost + $print_cost + $laminating_cost + $die_cutting_cost;
            echo"Total service cost :" . round($tot_service_cost);
            echo"Total Production cost : " . (round($tot_service_cost, 2) + round(sales_material_cost($tot_material_cost), 2));

            break;
            
//-------------------leaflet----------------------------------------------------
        case 18: 
            //define variable
            $ppr_size = $ppr_color = $ppr_thick = $ink_unit_price = $print = $ppr_cost = $print_type = $ink_cost = $length = $width = $serface = $width_id = null;
            //Asign value
            $ppr_size = clean_input($_POST['paper_size#1']);
            $ppr_thick = clean_input($_POST['paper_thick#7']);
            $ppr_color = clean_input($_POST['paper_colour#2']);
            $print = clean_input($_POST['print#37']);

            $print_type = 149; //offset print
            $serface = 0.9; // offset serface of print
//1 paper-----------------------------------------------------------------------            
            //paper cost
            $ppr_cost = ( avlable_itm_max_price(1, $ppr_size, $ppr_thick, $ppr_color) * $pro_qty);
//              echo "remain quntity : ".$remain_sq = stock_use($pro_qty,1, $ppr_size, $ppr_thick, $ppr_color);
              
//end paper---------------------------------------------------------------------
//2 ink ------------------------------------------------------------------------
            if ($print == 161) {// color 1/1 black
                $color_type = 46; // black
                $ink_unit_price = avlable_itm_max_price(5, $color_type, $print_type);
            } elseif ($print == 162) {//color 4/4 cmyk
                // price for all 4 colors 
                for ($color_type = 43; $color_type <= 46; $color_type++) {
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

            echo $ink_cost = $ink_unit_price * $pro_qty * $length * $width * $serface / 1000000;
//end ink-----------------------------------------------------------------------
//total quate for meterials-----------------------------------------------------
            $tot_material_cost = $ink_cost + $ppr_cost;
            // sales price of item 30% added to actual cost
            echo "Total Cost Of Paper(" . pro_id_to_val($ppr_size) . " x " . $pro_qty . " Sheets  ) : " . $ppr_cost * 1.3;

            echo "Total Ink Cost For Print ( Width " . $width . "(mm) x Length " . $length . "(mm)  Quantity of " . $pro_qty . ") : " . $ink_cost * 1.3;

            echo"Total Cost Of Materials : " . round($tot_material_cost * 1.3, 2);
            
            
// service cost-----------------------------------------------------------------
//01 design---------------------------------------------------------------------
            echo "task cost of designing :" . $design_cost = task_cost(7, $width * $length)/8;
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
            echo "task cost of die cutting :" . $die_cutting_cost;
// Total service cost ----------------------------------------------------------           
            $tot_service_cost = $design_cost + $print_cost + $die_cutting_cost;
            echo"Total Cost Of Service : " . round($tot_service_cost, 2);
//total production cost---------------------------------------------------------
            echo"Total Production cost : " . (round($tot_service_cost, 2) + round(sales_material_cost($tot_material_cost), 2));

            
            

            break;
        default :
    }
    


//        $sql = "SELECT * FROM `tb_stock` s 
//LEFT JOIN tb_accessory_property ap1 on s.accessory_id = ap1.accessory_id 
//LEFT JOIN tb_accessory_property ap2 on s.accessory_id = ap2.accessory_id 
//LEFT JOIN tb_accessory_property ap3 on s.accessory_id = ap3.accessory_id 
//WHERE 
//s.accessory_type_id = 1
//AND
//ap1.property_value_id= 1 
//AND
//ap2.property_value_id = 24 
//AND 
//ap3.property_value_id = 35";
   

//    $sql = "SELECT tb_product_property.property_id, tb_product_property.property, tb_product_property.type FROM tb_product_property_assign LEFT JOIN tb_product_property ON tb_product_property.property_id=tb_product_property_assign.property_id WHERE tb_product_property_assign.product_id = '$pro_id'";
//    $result = $conn->query($sql);
//    if ($result->num_rows > 0) {
//        while ($row = $result->fetch_assoc()) {
//            $property[] = array($row['property'], $row['type'], $row['property_id']);
//        }
//
//        $sql = null;
//
//        foreach ($property as $value) {
//            $pro_value = null;
//             $field = strtolower(str_replace(" ", "_", $value[0]));
//             //radio button
//            if ($value[1] == "R") {
//                if (isset($_POST[$field])) {
//                    $pro_value = $_POST[$field];
//                }
//                // empty validation
//                if (empty($pro_value)) {
//                   // $x[$field]="<div class='alert alert-danger'>" . $value[0] . " shoud not be empty</div>";
//                    echo"<div class='alert alert-danger'>" . $value[0] . " shoud not be empty</div>";
//                    $e = 0;
//                } else {
//                    $sql[] = "Insert into tb_order_property(order_id,property_id,value) values('#','" . $value[2] . "','" . $pro_value . "')";
//                }
//            }
//            //combo box
//            if ($value[1] == "C") {
//                $pro_value = $_POST[$field];
//                // empty validation
//                if (empty($pro_value)) {
////                    echo"<div class='alert alert-danger'>" . $value[0] . " shoud not be empty</div>";
//                     $x[$field]="<div class='alert alert-danger'>" . $value[0] . " shoud not be empty</div>";
//                    $e = 0;
//                } else {
//                    $sql[] = "Insert into tb_order_property(order_id,property_id,value) values('#','" . $value[2] . "','" . $pro_value . "')";
//                }
//            }
//           //number
//            if ($value[1] == "N") {
//                $pro_value = $_POST[$field];
//                // empty validation
//                if (empty($pro_value)) {
////                    echo"<div class='alert alert-danger'>" . $value[0] . " shoud not be empty</div>";
//                     $x[$field] = "<div class='alert alert-danger'>" . $value[0] . " shoud not be empty</div>";
//                    $e = 0;
//                } else if (!is_numeric($pro_value)) {
//                    $x[$field] = "<div class='alert alert-danger'>" . $value[0] . " shoud be number input</div>";
//                    $e = 0;
//                } else {
//                    $sql[] = "Insert into tb_order_property(order_id,property_id,value) values('#','" . $value[2] . "','" . $pro_value . "')";
//                }
//            }
//        }
//    }
//
//
////-----------------------------------validation---------------------------------
//    /*
//      ------------validation format---------------------------------------------
//     * 
//      if(empty(variable)){
//      ----empty validation-------
//      }else{
//      ----advanced validation----
//      }
//     */
//    if (empty($pro_qty)) {
//        $x['pro_qty'] = "<div class='alert alert-danger'>Product quantity shoud not be empty</div>";
//        $e = 0;
//    } else {
//        if ($pro_qty <= 0) {
//            $x['pro_qty'] = "<div class='alert alert-danger'>Product quantity invalid</div>";
//            $e = 0;
//        }
//    }
//
////    if (empty($d_comment)) {
////        $x['d_comment'] = "<div class='alert alert-danger'>Design Comment shoud not be empty</div>";
////        $e = 0;
////    }
//
//    if (empty($cus_name)) {
//       $x['cus_name'] = "<div class='alert alert-danger'>Name shoud not be empty</div>";
//        $e = 0;
//    } else {
//        if (!preg_match("/^[a-zA-Z ]*$/", $cus_name)) {
//            $x['cus_name'] = "<div class='alert alert-danger'>Name is invalid...!</div>";
//            $e = 0;
//        }
//    }
//
////    if (empty($d_address)) {
////        $x['d_address'] = "<div class='alert alert-danger'>Delivery Address shoud not be empty</div>";
////        $e = 0;
////    }
//
//    if (empty($email)) {
//      $x['email'] = "<div class='alert alert-danger'>Email address shoud not be empty</div>";
//        $e = 0;
//    } else {
//        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//           $x['email'] = "<div class='alert alert-danger'>The Email address is invalid...!</div>";
//            $e = 0;
//        }
//    }
//
////    if (empty($tp_no)) {
////        $x['tp_no'] = "<div class='alert alert-danger'>Telephone number shoud not be empty</div>";
////        $e = 0;
////    } else {
////        if (!preg_match("/^[0-9+]*$/", $tp_no)) {
////            $x['tp_no'] = "<div class='alert alert-danger'>The tlephone number is invalid...!</div>";
////            $e = 0;
////        }
////    }
//
//// -----------------------end validation----------------------------------------
//
//    if ($e == 1) {
//        
//           $x['quate'] ="<div class='alert alert-success'>Rs. 1500.00</div>";
//           echo $msg = json_encode($x);
////        echo "New record created successfully. Last inserted ID is: " . $order_id;
//        
//    }else{
//        
////        $x["paper_size"] = "paper size should not be blank";
////        $x["paper_thick"] = "paper thick should not be blank";
//        
//        echo $msg = json_encode($x);
//        
//    }
}
?>