<!--
Page Name: register.php(supplier)
Date Created :28/10/2020
-->
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//Check Page Request Method 
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "insert")) {
    //Define variables
    $com_nm = $address = $div_sec = $con_pnm = $tp_no = $email = $web = $bnk_nm = $bnk_acc = $s_tool = $s_acc = null;
    //print_r($_POST);
    $s_acc = $s_tool = array();
    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------
    $com_nm = ucfirst(clean_input($_POST['com_nm']));
    $address = clean_input($_POST['address']);
    $div_sec = $_POST['divsecretariat'];
    $con_pnm = clean_input($_POST['cp_nm']); //contact person name
    $tp_no = clean_input($_POST['tp_no']);
    $email = clean_input($_POST['email']);
    $web = clean_input($_POST['web']);
    $bnk_nm = clean_input($_POST['bnk_nm']);
    $bnk_acc = clean_input($_POST['acc_no']);
    if (isset($_POST['s_acc'])) {
        $s_acc = $_POST['s_acc'];
        print_r($s_acc);
    }
    if (isset($_POST['s_tool'])) {
        $s_tool = $_POST['s_tool'];
    }

    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($com_nm)) {
        $e['com_nm'] = "The Company Name should not be empty....!";
    }
    if (empty($address)) {
        $e['address'] = "The Company address should not be empty....!";
    }
    if (empty($div_sec)) {
        $e['div_sec'] = "The divisional secretariat should not be empty....!";
    }
    if (empty($con_pnm)) {
        $e['con_pnm'] = "The Contact person name should not be empty....!";
    }
    if (empty($tp_no)) {
        $e['tp_no'] = "The telephone number should not be empty....!";
    }
    if (empty($email)) {
        $e['email'] = "The email address should not be empty....!";
    }

//     if (empty($bnk_nm)) {
//        $e['bnk_nm'] = "The Bank Name should not be empty....!";
//    }
//     if (empty($bnk_acc)) {
//        $e['bnk_acc'] = "The Bank Account number should not be empty....!";
//    }
    if (empty($s_tool) && empty($s_acc)) {
        $e['s_tool'] = "The tool-category and item-category both should not be empty....!";
        $e['s_acc'] = "The item-category and tool-category both should not be empty....!";
    }


    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($com_nm)) {
        if (!preg_match("/^[a-zA-Z.() ]*$/", $com_nm)) {
            $e['com_nm'] = "The company name is invalid...!";
        }
    }
    if (!empty($con_pnm)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $con_pnm)) {
            $e['con_pnm'] = "The contact person name is invalid...!";
        }
    }
    if (!empty($tp_no)) {
        if (!preg_match("/^[0-9+]*$/", $tp_no)) {
            $x['tp_no'] = "<div class='alert alert-danger'>The tlephone number is invalid...!</div>";
            $e = 0;
        }
        // telephone number already exsist validation

        $sql = "SELECT `tp_no` FROM `tb_supplier` WHERE `tp_no`= '$tp_no'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $e['tp_no'] = "Telephone number is already exist..!";
        }
    }

    if (!empty($con_pnm)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $con_pnm)) {
            $e['con_pnm'] = "The contact person name is invalid...!";
        }
    }

    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $e['email'] = "The Email address is invalid...!";
        }
    }
    if (!empty($web)) {
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $web)) {
            $e['web'] = "URL is invalid...!";
        }
    }
    if (!empty($bnk_nm)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $bnk_nm)) {
            $e['bnk_nm'] = "The bank name is invalid...!";
        }
    }

    if (!empty($bnk_acc)) {
        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $bnk_acc)) {
            $e['bnk_acc'] = "The bank account number is invalid...!";
        }
    }
    //End advance validation---------------------------
    //data send to database----------------------------

    if (empty($e)) {
        var_dump($s_tool);
        echo $sql = "INSERT INTO `tb_supplier`
            (`com_nm`, `address`, `DivSec_Code`, `cont_per_nm`, `tp_no`, `email`, `web`, `bank_nm`, `bank_acc_no`) 
             VALUES ('$com_nm','$address','$div_sec','$con_pnm','$tp_no','$email','$web','$bnk_nm','$bnk_acc')";
        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade_show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! supplier registered</strong>

            </div>
            <?php
            $supplier_id = $conn->insert_id;

            if (!empty($s_acc)) {
                foreach ($s_acc as $value_acc) {
                    echo $sql = "INSERT INTO `tb_suplier_accessory_type`(`supplier_id`, `accessory_type_id`) VALUES ('$supplier_id','$value_acc')";
                    $conn->query($sql);
                    $com_nm = $address = $div_sec = $con_pnm = $tp_no = $email = $web = $bnk_nm = $bnk_acc = $s_acc = $s_tool = null;
                }
            }
            if (!empty($s_tool)) {
                foreach ($s_tool as $value_tool) {
                    echo $sql = "INSERT INTO `tb_supplier_tool_group`(`supplier_id`, `group_code`) VALUES ('$supplier_id','$value_tool')";
                    $conn->query($sql);
                    $com_nm = $address = $div_sec = $con_pnm = $tp_no = $email = $web = $bnk_nm = $bnk_acc = $s_acc = $s_tool = null;
                }
            }
//            $com_nm = $address = $div_sec = $con_pnm = $tp_no = $email = $web = $bnk_nm = $bnk_acc = $sup_cat = $s_type = null;
        } else {
            echo "Error" . $conn->error;
        }
    }
//    end data send to database------------------------------
}




//Check Page Request Method and data edit 
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "edit") {
    //Define variables
    $supplier_id = $com_nm = $address = $div_sec = $con_pnm = $tp_no = $email = $web = $bnk_nm = $bnk_acc = $s_acc = $s_tool = null;
    $s_acc = $s_tool = array();
    $supplier_id = $_POST['supplier_id'];
    $sql_edit = "SELECT 
                 `com_nm`,
                 `address`,
                 `DivSec_Code`,
                 `cont_per_nm`,
                 `tp_no`,
                 `email`,
                 `web`, 
                 `bank_nm`,
                 `bank_acc_no`
                  FROM `tb_supplier` 
                  WHERE `supplier_id`='$supplier_id'";
    $result_edit = $conn->query($sql_edit);
    if ($result_edit->num_rows > 0) {
        while ($row = $result_edit->fetch_assoc()) {
            $com_nm = $row['com_nm'];
            $address = $row['address'];
            $div_sec = $row['DivSec_Code'];
            $con_pnm = $row['cont_per_nm'];
            $tp_no = $row['tp_no'];
            $email = $row['email'];
            $web = $row['web'];
            $bnk_nm = $row['bank_nm'];
            $bnk_acc = $row['bank_acc_no'];
        }
        $sql_edit = "SELECT `Dis_Code` FROM `tb_divsecretariat` WHERE DivSec_Code = '" . $div_sec . "'";
        $result_edit = $conn->query($sql_edit);
        if ($result_edit->num_rows > 0) {
            while ($rowdiv = $result_edit->fetch_assoc()) {
                @$dis_code = $rowdiv['Dis_Code'];
            }
        }
    }
    $sql_edit = "SELECT `group_code` FROM `tb_supplier_tool_group` WHERE `supplier_id` = '$supplier_id'";
    $result_edit = $conn->query($sql_edit);

    if ($result_edit->num_rows > 0) {
        while ($rowst = $result_edit->fetch_assoc()) {
            array_push($s_tool, $rowst['group_code']);
        }
    }

    $sql_edit = "SELECT `accessory_type_id` FROM `tb_suplier_accessory_type` WHERE `supplier_id` = '$supplier_id'";
    $result_edit = $conn->query($sql_edit);

    if ($result_edit->num_rows > 0) {
        while ($rowsa = $result_edit->fetch_assoc()) {
            array_push($s_acc, $rowsa['accessory_type_id']);
        }
    }
   
}


//Check Page Request Method post and update status 
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "update")) {
    //Define variables
    $suplier_id = $com_nm = $address = $div_sec = $con_pnm = $tp_no = $email = $web = $bnk_nm = $bnk_acc = $s_acc = $s_tool = null;

    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------
    echo $supplier_id = $_POST['supplier_id'];
    $com_nm = ucfirst(clean_input($_POST['com_nm']));
    $address = clean_input($_POST['address']);
    $div_sec = $_POST['divsecretariat'];
    $con_pnm = clean_input($_POST['cp_nm']); //contact person name
    $tp_no = clean_input($_POST['tp_no']);
    $email = clean_input($_POST['email']);
    $web = clean_input($_POST['web']);
    $bnk_nm = clean_input($_POST['bnk_nm']);
    $bnk_acc = clean_input($_POST['acc_no']);
    if (isset($_POST['s_tool'])) {
        $s_tool = $_POST['s_tool'];
    }
    if (isset($_POST['s_acc'])) {
        $s_acc = $_POST['s_acc'];
    }

    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($com_nm)) {
        $e['com_nm'] = "The Company Name should not be empty....!";
    }
    if (empty($address)) {
        $e['address'] = "The Company address should not be empty....!";
    }
    if (empty($div_sec)) {
        $e['div_sec'] = "The divisional secretariat should not be empty....!";
    }
    if (empty($con_pnm)) {
        $e['con_pnm'] = "The Contact person name should not be empty....!";
    }
    if (empty($tp_no)) {
        $e['tp_no'] = "The telephone number should not be empty....!";
    }
    if (empty($email)) {
        $e['email'] = "The email address should not be empty....!";
    }

//     if (empty($bnk_nm)) {
//        $e['bnk_nm'] = "The Bank Name should not be empty....!";
//    }
//     if (empty($bnk_acc)) {
//        $e['bnk_acc'] = "The Bank Account number should not be empty....!";
//    }
   
      if (empty($s_tool) && empty($s_acc)) {
        $e['s_tool'] = "The tool-category and item-category both should not be empty....!";
        $e['s_acc'] = "The item-category and tool-category both should not be empty....!";
    }
    //End check input fields are empty-----------------
    
    //Advance validation-------------------------------
    if (!empty($com_nm)) {
        if (!preg_match("/^[a-zA-Z.() ]*$/", $com_nm)) {
            $e['com_nm'] = "The company name is invalid...!";
        }
    }
    if (!empty($con_pnm)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $con_pnm)) {
            $e['con_pnm'] = "The contact person name is invalid...!";
        }
    }
    if (!empty($tp_no)) {
        if (!preg_match("/^[0-9+]*$/", $tp_no)) {
            $x['tp_no'] = "<div class='alert alert-danger'>The tlephone number is invalid...!</div>";
            $e = 0;
        }
        // telephone number already exsist validation
//        $sql = "SELECT `tp_no` FROM `tb_supplier` WHERE `tp_no`= '$tp_no'";
//        $result = $conn->query($sql);
//        if ($result->num_rows > 0) {
//            $e['tp_no'] = "Telephone number is already exist..!";
//        }
    }

    if (!empty($con_pnm)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $con_pnm)) {
            $e['con_pnm'] = "The contact person name is invalid...!";
        }
    }

    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $e['email'] = "The Email address is invalid...!";
        }
    }
    if (!empty($web)) {
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $web)) {
            $e['web'] = "URL is invalid...!";
        }
    }
    if (!empty($bnk_nm)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $bnk_nm)) {
            $e['bnk_nm'] = "The bank name is invalid...!";
        }
    }

    if (!empty($bnk_acc)) {
        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $bnk_acc)) {
            $e['bnk_acc'] = "The bank account number is invalid...!";
        }
    }
    //End advance validation---------------------------
    //database connectivity------------------------------
    if (empty($e)) {

        print_r($s_acc);
        print_r($s_tool);

         $sql = "UPDATE `tb_supplier` SET `com_nm`='$com_nm',`address`='$address',`DivSec_Code`='$div_sec',`cont_per_nm`='$con_pnm',`tp_no`='$tp_no',`email`='$email',`web`='$web',`bank_nm`='$bnk_nm',`bank_acc_no`='$bnk_acc' WHERE `supplier_id`= '$supplier_id'";

        if ($conn->query($sql) === true) {
            $com_nm = $address = $div_sec = $con_pnm = $tp_no = $email = $web = $bnk_nm = $bnk_acc = null;
                        
           if (!empty($s_acc)) {
                    $sql = "DELETE FROM `tb_suplier_accessory_type` WHERE `supplier_id` = $supplier_id";
                    $conn->query($sql);
               
               
                foreach ($s_acc as $value_acc) {  
                    $sql = "INSERT INTO `tb_suplier_accessory_type`(`supplier_id`, `accessory_type_id`) VALUES ('$supplier_id','$value_acc')";
                    $conn->query($sql);
                    $s_acc  = null;
                }
            }
            if (!empty($s_tool)) {
                
                $sql = "DELETE FROM `tb_supplier_tool_group` WHERE `supplier_id` = $supplier_id";
                $conn->query($sql);
                
                foreach ($s_tool as $value_tool) {
                   $sql = "INSERT INTO `tb_supplier_tool_group`(`supplier_id`, `group_code`) VALUES ('$supplier_id','$value_tool')";
                   $conn->query($sql);
                    $s_tool = null;
                }
            }
             $suplier_id= null;
            ?>
            <div class="alert alert-success alert-dismissible fade_show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! data updated</strong>
            </div>
            <?php
        
            // header("Refresh:3");
        } else {
            echo "Error" . $conn->error;
        }
    }
    //end data send to database------------------------------
}
?>




<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Supplier Creation</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" method="post"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="com_nm">Company Name :</label>
                        <input type="text" class="form-control" id="com_nm" name="com_nm" placeholder="Enter company name" value="<?php echo @$com_nm; ?>">
                        <div class="text-danger"><?php echo @$e['com_nm']; ?></div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="address">Address :</label>
                        <textarea class="form-control" id="address" name="address" placeholder="Enter office address"><?php echo @$address; ?></textarea>
                        <div class="text-danger"><?php echo @$e['address']; ?></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <?php
                        $sql = "SELECT * FROM tb_district";
                        $result = $conn->query($sql);
                        ?>
                        <label for="district">District</label>
                        <select class="form-control" id="district" name="district" onchange="loadDivSec(this.value);">
                            <option value="">--Select a District--</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['dis_code']; ?>"<?php if (@$dis_code == $row['dis_code']) { ?> selected<?php } ?> > <?php echo $row['district']; ?> </option>
                                    <?php
                                }
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group" id="result_dis_sec">
                        <?php
                        $sql = "SELECT * FROM tb_divsecretariat";
                        $result = $conn->query($sql);
                        ?>
                        <label for="divsecretariat">Divisional Secretariat</label>
                        <select class="form-control" id="divsecretariat" name="divsecretariat" >
                            <option value="">--Select a District--</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['DivSec_Code']; ?>"<?php if (@$div_sec == $row['DivSec_Code']) { ?> selected<?php } ?>><?php echo $row['DivSecretariat'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="text-danger"><?php echo @$e['div_sec']; ?></div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="cp_nm">Contact Person Name :</label>
                        <input type="text" class="form-control" id="cp_nm" name="cp_nm" placeholder="Enter contact name" value="<?php echo @$con_pnm; ?>">
                        <p>(for communications regarding bids/proposals/other information)</p>
                        <div class="text-danger"><?php echo @$e['con_pnm']; ?></div>
                    </div>

                </div>
                <div class="col">
                    <!-- phone mask -->
                    <div class="form-group">
                        <label for="tp_no">Telephone No :</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control" name="tp_no" id="tp_no" placeholder="Enter telephone number" value="<?php echo @$tp_no; ?>">
                        </div>
                        <!-- /.input group -->
                        <div class="text-danger"><?php echo @$e['tp_no']; ?></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="email">Email address :</label>
                        <input type="text" name="email" id="email" class="form-control"  placeholder="Enter email" value="<?php echo @$email; ?>">
                        <div class="text-danger"><?php echo @$e['email']; ?></div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="web">Website :</label>
                        <input type="text" name="web" id="web" class="form-control"  placeholder="Enter website link" value="<?php echo @$web; ?>">
                        <div class="text-danger"><?php echo @$e['web']; ?></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="bnk_nm">Bank Name :</label>
                        <input type="text" class="form-control" id="bnk_nm" name="bnk_nm" placeholder="Enter bank name " value="<?php echo @$bnk_nm; ?>">
                        <div class="text-danger"><?php echo @$e['bnk_nm']; ?></div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="acc_no">Bank Account No :</label>
                        <input type="text" class="form-control" id="acc_no" name="acc_no" placeholder="Enter bank account number" value="<?php echo @$bnk_acc; ?>">
                        <div class="text-danger"><?php echo @$e['bnk_acc']; ?></div>
                    </div>
                </div>
            </div>

            <!--            <div class="form-group">
                            <label for="fix">Supply Type :</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="s_type" id="s_type" onchange="show_hide_services(this.value)" value="acc"<?php //if (@$s_type == "acc") {  ?>checked <?php //}  ?>>
                                    <label class="form-check-label" for="acc">Accessory</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="s_type" id="s_type" onchange="show_hide_services(this.value)" value="tool"<?php // if (@$s_type == "tool") {  ?>checked <?php //}  ?>>
                                    <label class="form-check-label" for="tool">Tool</label>
                                </div>
                            </div>
                        </div>-->







            <div class="row">
                <div class="col">
                    <div class="form-group" id="item_category" >
                        <label for="s_acc">Supply item category :</label>
                        <?php
                        $sql = "SELECT * FROM `tb_accessory_type`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                //dynamicaly create name,id
                                // $field = strtolower(str_replace(" ", "_", $row['name']));
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $row['accessory_type_id']; ?>" id="<?php echo $row['accessory_type_id']; ?>" name="s_acc[]" <?php
                        if (!empty($s_acc)) {
                            if (in_array($row['accessory_type_id'], @$s_acc)) {
                                        ?>checked <?php
                                               }
                                           }
                                           ?>>
                                    <label class="form-check-label" for="<?php echo $row['accessory_type_id']; ?>">
                                        <?php echo $row['name'] ?>
                                    </label>
                                </div>
                                <?php
                            }
                        }
                        ?>

                        <div class="text-danger"><?php echo @$e['s_acc']; ?></div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group" id="tool_category" >
                        <label for="s_tool">Supply Tool category :</label>
                        <?php
                        $sql = "SELECT * FROM `tb_tool_group`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                //dynamicaly create name,id
                                // $field = strtolower(str_replace(" ", "_", $row['group']));
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $row['group_code']; ?>" id="<?php echo $row['group_code']; ?>" name="s_tool[]" <?php
                        if (!empty($s_tool)) {
                            if (in_array($row['group_code'], @$s_tool)) {
                                        ?>checked<?php
                                               }
                                           }
                                           ?> >
                                    <label class="form-check-label" for="<?php echo $row['group_code']; ?>">
                                        <?php echo $row['group'] ?>
                                    </label>
                                </div>
                                <?php
                            }
                        }
                        ?>

                        <div class="text-danger"><?php echo @$e['s_tool']; ?></div>
                    </div>
                </div>
            </div>




























        </div>
        <!-- /.card-body -->

        <div class="card-footer">

            <?php if (@$_POST['operate'] != "edit") { ?>
                <button type="submit" name="operate" value="insert" class="btn btn-primary">Create</button>
                <?php
            }
            ?>


            <?php if (@$_POST['operate'] == "edit") { ?>
                <input type="hidden" name="supplier_id" value="<?php echo $supplier_id; ?>">
                <button type="submit" type="hidden" name="operate" id="update_btn" value="update"  class="btn btn-primary">Update</button>
                <?php
            }
            ?>
            <button type="submit" name="operate" value="cancel" class="btn btn-info">Cancel</button>                                            
        </div>
    </form>
    <!-- form end -->
</div>

<?php
//sql for list table
$sql_view = "SELECT `supplier_id`, `com_nm`,  `tp_no`, cont_per_nm FROM `tb_supplier`";


//Check Page Request Method and data search 
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "search") {
    //$module_id = $description = $menu_index ;
    $search = $search_type = null;
    //define arry for display error messages
    $e = array();

    //Assign Data--------------------------------------
    $search_type = $_POST['search_type'];
    $search = clean_input($_POST['search']);

    //Check input fields are empty---------------------
    if (empty($search_type)) {
        $e['search_type'] = "The search type should not be empty....!";
    }
    if (empty($search)) {
        $e['search'] = "The search value should not be empty....!";
    }
    //advanced validation
    if (!empty($search_type && $search)) {
        if ($search_type == "tp_no") {
            if (!preg_match("/^[0-9]*$/", $search)) {
                $e['search'] = "The Telephone number is invalid...!";
            }
        }
        if ($search_type == "address") {
//                    if (!preg_match("/^[a-zA-Z0-9@.]*$/", $search)) {
//                        $e['search'] = "enterd user name is invalid...!";
//                    }
        }
        if ($search_type == "email") {
            if (!filter_var($search, FILTER_VALIDATE_EMAIL)) {
                $e['search'] = "entered email is invalid...!";
            }
        }
        if ($search_type == "cont_per_nm") {

            if (!preg_match("/^[a-zA-Z ]*$/", $search)) {
                $e['search'] = "entered name is invalid...!";
            }
        }
        if ($search_type == "com_nm") {
            if (!preg_match("/^[a-zA-Z ]*$/", $search)) {
                $e['search'] = "entered name is invalid...!";
            }
        }
        //not exist validation
        if (empty($e['search'])) {
            $sql = "SELECT `$search_type` FROM `tb_supplier` WHERE `$search_type` LIKE '%$search%'";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                $e['search'] = "entered data is not exist..";
            }
        }
    }
    if (empty($e)) {
        $sql_view = "SELECT `supplier_id`, `com_nm`, `tp_no`, cont_per_nm FROM `tb_supplier` WHERE `$search_type` LIKE '%$search%'";
    }
}
$result_view = $conn->query($sql_view);
?>

<div class="card card-primary">
    <div class="card-header">
        <div class="col">
            <h3 class="card-title">Search</h3>
        </div>
    </div>
    <div class="card-body  ">
        <div class="container-fluid">
            <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="search_type">Search Type :</label>
                            <select class="form-control select2"  name="search_type" id="search_type">
                                <option value="">select parameter</option>
                                <option value="com_nm">company name</option>
                                <option value="cont_per_nm">contact person name</option>
                                <option value="tp_no">telephone</option>
                                <option value="email">email</option>
                                <option value="address">address</option>
                            </select>
                            <div class="text-danger"><?php echo @$e['search_type']; ?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">

                            <label for="serch_data">Search Input :</label>
                            <div class="input-group-append">
                                <input type="text" class="form-control" id="search" name="search" placeholder="Search">
                                <button class="btn btn-default" name="operate" type="submit" id="search_btn" value="search" onmouseover="this.style.color = '#17a2b8 '" onmouseout="this.style.color = '#383f45'">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="text-danger"><?php echo @$e['search']; ?></div>
                        </div>
                    </div>
                </div>            

            </form>
        </div>
    </div>
    <!--card header 2nd-->
    <div class="card-header">

        <div class="row">
            <div class="col">
                <h3 class="card-title">View Supplier</h3>
            </div>
            <div class="col">
                <?php
                echo"Supplier count: " . $result_view->num_rows;
                ?>
            </div>
        </div>
    </div> 
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive-md">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact Person</th>
                        <th>Telephone No</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_view->num_rows > 0) {
                        while ($row = $result_view->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['com_nm']; ?></td>
                                <td><?php echo $row['cont_per_nm']; ?></td>
                                <td><?php echo $row['tp_no']; ?></td>

                                <td >
                                    <form method="post" action="supp_view.php">
                                        <input type="hidden" name="supplier_id" value="<?php echo $row['supplier_id']; ?>">
                                        <button type="submit" name="operate" value="view" class="btn btn-default" onmouseover="this.style.color = '#cad315'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-eye"></i></button>         
                                    </form>
                                </td>
                                <td>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <input type="hidden" name="supplier_id" value="<?php echo $row['supplier_id']; ?>">
                                        <button type="submit" name="operate" value="edit" class="btn btn-default" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-edit"></i></button>                   
                                    </form>
                                </td>
                                <td >
                                    <form method="post" action="supp_dlt.php">
                                        <input type="hidden" name="supplier_id" value="<?php echo $row['supplier_id']; ?>">

                                        <button type="submit" name="operate" value="delete" class="btn btn-default" onmouseover="this.style.color = '#ff1a1a'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-trash-alt"></i></button>                   
                                    </form>  
                                </td>

                            </tr>

                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!--responsive table-->
    </div>
    <!--./card-body-->
</div>
<!--/.card card-primary-->


<?php include '../footer.php'; ?>
<script type="text/javascript">

    function loadDivSec(dis_code) {
        var mydata = "dis_code=" + dis_code + "&";
//   alert(mydata);
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "dis_sec_combo.php",
            success: function (data) {
                $("#result_dis_sec").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }

//    $("#tool_category").hide();
//    $("#item_category").hide();
//    function show_hide_services(s_type) {
//        $("#tool_category").hide();
//        $("#item_category").hide();
//
//        if (s_type == "acc") {
//            $("#item_category").show();
////            $("#tool_category").hide();
//
//        }
//        
//        if (s_type == "tool") {
//            $("#tool_category").show();
////            $("#item_category").hide();
//
//        }
//        
//        
//    }

</script>