<?php
ob_start();
?>
<?php include '../header.php'; ?>

<?php include '../nav.php'; ?>
<?php
//Check Page Request Method 
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "insert")) {
    //Define variables
    $tool_grp = $serial = $brand = $model = $mn_date = $bt_price = $bt_date = $condition = $warranty = $unit_cost = $service = $sup_id = null;
    //define arry for display error messages
    $e = array();

    //Assign Data--------------------------------------
    $tool_grp = $_POST['tool_grp'];
    $serial = clean_input($_POST['serial']);
    $brand = clean_input($_POST['brand']);
    $model = clean_input($_POST['model']);
    $mn_date = $_POST['mn_date'];
    $bt_price = clean_input($_POST['bt_price']);
    $bt_date = $_POST['bt_date'];
    if (isset($_POST['condition'])) {
        $condition = $_POST['condition'];
    }
    $warranty = clean_input($_POST['warranty']);
    $unit_cost = clean_input($_POST['unit_cost']);
    $service = clean_input($_POST['service']);
    $sup_id = $_POST['supplier'];
    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($tool_grp)) {
        $e['tool_grp'] = "The tool group should not be empty...!";
    }
    if (empty($serial)) {
        $e['serial'] = "The serial number should not be empty....!";
    }
    if (empty($brand)) {
        $e['brand'] = "The brand name should not be empty....!";
    }
    if (empty($model)) {
        $e['model'] = "The model should not be empty....!";
    }
    if (empty($mn_date)) {
        $e['mn_date'] = "The manufacture date should not be empty....!";
    }
    if (empty($bt_price)) {
        $e['bt_price'] = "The bought price should not be empty....!";
    }
    if (empty($bt_date)) {
        $e['bt_date'] = "The bought date should not be empty....!";
    }
    if (empty($condition)) {
        $e['condition'] = "The condition should not be empty....!";
    }
    if (empty($warranty)) {
        $e['warranty'] = "The warrenty period should not be empty....!";
    }
    if (empty($unit_cost)) {
        $e['unit_cost'] = "The unit cost should not be empty....!";
    }
    if (empty($service)) {
        $e['service'] = "The service should not be empty....!";
    }
    if (empty($sup_id)) {
        $e['supplier'] = "The supplier should not be empty....!";
    }
    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($serial)) {
        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $serial)) {
            $e['con_pnm'] = "The serial no is invalid...!";
        }
    }
    if (!empty($brand)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $brand)) {
            $e['com_nm'] = "The brand name is invalid...!";
        }
    }
    
    if (!empty($model)) {
        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
            $e['con_pnm'] = "The model is invalid...!";
        }
    }
    if (!empty($mn_date)) {
//        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
//            $e['con_pnm'] = "The model is invalid...!";
//        }
    }
    if (!empty($bt_price)) {
//        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
//            $e['con_pnm'] = "The model is invalid...!";
//        }
    }
    if (!empty($bt_date)) {
//        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
//            $e['con_pnm'] = "The model is invalid...!";
//        }
    }
    if (!empty($warranty)) {
//        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
//            $e['con_pnm'] = "The model is invalid...!";
//        }
    }
    if (!empty($unit_cost)) {
//        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
//            $e['con_pnm'] = "The model is invalid...!";
//        }
    }
    if (!empty($service)) {
//        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
//            $e['con_pnm'] = "The model is invalid...!";
//        }
    }
    //End advance validation---------------------------
    //data send to database----------------------------
    if (empty($e)) {
//        
        $sql = "INSERT INTO `tb_equipment`
            ( `group_code`, `serial_no`,`brand`, `model`, `manufacture_date`, `bought_price`, `bought_date`, `cond`, `warranty`, `unit_cost`, `service`, `supplier_id`) 
             VALUES ('$tool_grp','$serial','$brand','$model','$mn_date','$bt_price','$bt_date','$condition','$warranty','$unit_cost','$service','$sup_id')";
        if ($conn->query($sql) === true) {
             $_SESSION['emp_id']  = $conn->insert_id;
              $_SESSION['tool_grp'] = $tool_grp;
            $tool_grp = $serial = $brand = $model = $mn_date = $bt_price = $bt_date = $condition = $warranty = $unit_cost = $service = $sup_id = null;
            
            ?>
            <div class="alert alert-success alert-dismissible fade_show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! Equipment registered</strong>
            </div>
            
            
         <?php
        
        
//             header('Location:function.php');
        } else {
            echo "Error" . $conn->error;
        }
    }
//    end data send to database------------------------------
}
?>


<?php
//Edit equpment-------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "edit")) {
    // Define variable----------------------------------------------------------
    $eqp_id = $tool_grp = $brand = $model = $mn_date = $bt_price = $bt_date = $condition = $warranty = $unit_cost = $service = $sup_id = null;
    // Assign variable----------------------------------------------------------
    // Data retrive from database-----------------------------------------------
    $sql = "SELECT * FROM `tb_equipment` WHERE equipment_id = " . $_POST['eqp_id'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $eqp_id = $row['equipment_id'];
            $tool_grp = $row['group_code'];
            $serial = $row['serial_no'];
            $brand = $row['brand'];
            $model = $row['model'];
            $mn_date = $row['manufacture_date'];
            $bt_price = $row['bought_price'];
            $bt_date = $row['bought_date'];
            $condition = $row['cond'];
            $warranty = $row['warranty'];
            $unit_cost = $row['unit_cost'];
            $service = $row['service'];
            $sup_id = $row['supplier_id'];
        }
    }
}
?>
<?php
//Check Page Request Method  and update methord
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "update")) {
    //Define variables
    $tool_grp = $brand = $model = $mn_date = $bt_price = $bt_date = $condition = $warranty = $unit_cost = $service = $sup_id = null;
    //define arry for display error messages
    $e = array();

    //Assign Data--------------------------------------
    $tool_grp = $_POST['tool_grp'];
    $serial = clean_input($_POST['serial']);
    $brand = clean_input($_POST['brand']);
    $model = clean_input($_POST['model']);
    $mn_date = $_POST['mn_date'];
    $bt_price = clean_input($_POST['bt_price']);
    $bt_date = $_POST['bt_date'];
    if (isset($_POST['condition'])) {
        $condition = $_POST['condition'];
    }
    $warranty = clean_input($_POST['warranty']);
    $unit_cost = clean_input($_POST['unit_cost']);
    $service = clean_input($_POST['service']);
    $sup_id = $_POST['supplier'];
    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($tool_grp)) {
        $e['tool_grp'] = "The tool group should not be empty...!";
    }
    if (empty($serial)) {
        $e['serial'] = "The serial number should not be empty....!";
    }
    if (empty($brand)) {
        $e['brand'] = "The brand name should not be empty....!";
    }
    if (empty($model)) {
        $e['model'] = "The model should not be empty....!";
    }
    if (empty($mn_date)) {
        $e['mn_date'] = "The manufacture date should not be empty....!";
    }
    if (empty($bt_price)) {
        $e['bt_price'] = "The bought price should not be empty....!";
    }
    if (empty($bt_date)) {
        $e['bt_date'] = "The bought date should not be empty....!";
    }
    if (empty($condition)) {
        $e['condition'] = "The condition should not be empty....!";
    }
    if (empty($warranty)) {
        $e['warranty'] = "The warrenty period should not be empty....!";
    }
    if (empty($unit_cost)) {
        $e['unit_cost'] = "The unit cost should not be empty....!";
    }
    if (empty($service)) {
        $e['service'] = "The service should not be empty....!";
    }
    if (empty($sup_id)) {
        $e['supplier'] = "The supplier should not be empty....!";
    }
    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($serial)) {
        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $serial)) {
            $e['con_pnm'] = "The serial no is invalid...!";
        }
    }
    if (!empty($brand)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $brand)) {
            $e['com_nm'] = "The brand name is invalid...!";
        }
    }
    if (!empty($model)) {
        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
            $e['con_pnm'] = "The model is invalid...!";
        }
    }
    if (!empty($mn_date)) {
//        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
//            $e['con_pnm'] = "The model is invalid...!";
//        }
    }
    if (!empty($bt_price)) {
//        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
//            $e['con_pnm'] = "The model is invalid...!";
//        }
    }
    if (!empty($bt_date)) {
//        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
//            $e['con_pnm'] = "The model is invalid...!";
//        }
    }
    if (!empty($warranty)) {
//        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
//            $e['con_pnm'] = "The model is invalid...!";
//        }
    }
    if (!empty($unit_cost)) {
//        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
//            $e['con_pnm'] = "The model is invalid...!";
//        }
    }
    if (!empty($service)) {
//        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model)) {
//            $e['con_pnm'] = "The model is invalid...!";
//        }
    }
    //End advance validation---------------------------
    //data send to database----------------------------
    if (empty($e)) {
//        
        $sql = "UPDATE `tb_equipment` SET `group_code`='$tool_grp',`serial_no`='$serial',`brand`='$brand',`model`='$model',`manufacture_date`='$mn_date',`bought_price`='$bt_price',`bought_date`='$bt_date',`cond`='$condition',`warranty`='$warranty',`unit_cost`='$unit_cost',`service`='$service',`supplier_id`='$sup_id' WHERE `equipment_id`=".$_POST['eqp_id'];
                                                             
        if ($conn->query($sql) === true) {
            $tool_grp = $brand = $model = $mn_date = $bt_price = $bt_date = $condition = $warranty = $unit_cost = $service = $sup_id = null;
            ?>
            <div class="alert alert-success alert-dismissible fade_show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! Equipment Updated..!</strong>
            </div>

            <?php
            
        } else {
            echo "Error" . $conn->error;
        }
    }
//    end data send to database------------------------------
}
?>

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Step 01 : Equipment Register </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                <div class="form-group" >
                    <?php
                    $sql_grp = "SELECT * FROM `tb_tool_group`";
                    $result_grp = $conn->query($sql_grp);
//$type_id = null;
                    ?>
                    <label for="tool_grp">Equipment Type :</label>
                    <select class="form-control select2" name="tool_grp" id="tool_grp" style="width: 100%;" onchange="loadPoperty(this.value);" >
                        <option value="">Select existing type</option>
                        <?php
                        if ($result_grp->num_rows > 0) {
                            while ($row_grp = $result_grp->fetch_assoc()) {
                                ?>

                                <option value="<?php echo $row_grp['group_code']; ?>"<?php if (@$tool_grp == $row_grp['group_code']) { ?> selected<?php } ?> > <?php echo $row_grp['group']; ?></option>

                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="text-danger"><?php echo @$e['tool_grp']; ?></div>
                </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="serial">Serial No :</label>
                            <input type="text" class="form-control" id="serial" name="serial" placeholder="Enter serial no" value="<?php echo @$serial; ?>">
                            <div class="text-danger"><?php echo @$e['serial']; ?></div>
                        </div>
                    </div>
                    
                    
                    
                </div>
                <!--row-->
                <div class="row">
                    
                    
                    <div class="col">
                        <div class="form-group">
                            <label for="brand">Brand :</label>
                            <input type="text" class="form-control" id="brand" name="brand" placeholder="Enter brand name" value="<?php echo @$brand; ?>">
                            <div class="text-danger"><?php echo @$e['brand']; ?></div>
                        </div>
                    </div>
                    
                    
                    <div class="col">
                        <div class="form-group">
                            <label for="model">Model :</label>
                            <input type="text" class="form-control" id="model" name="model" placeholder="Enter model name" value="<?php echo @$model; ?>">
                            <div class="text-danger"><?php echo @$e['model']; ?></div>
                        </div>
                    </div>  
                </div>
                <!--./row-->
              <!--!--row-->
                <div class="row">
                    <div class="col">
                <div class="form-group">
                    <label for="mn_date">Manufacture Date:</label>
                    <input type="date" class="form-control" id="mn_date" name="mn_date" value="<?php echo @$mn_date; ?>">
                    <div class="text-danger"><?php echo @$e['mn_date']; ?></div>
                </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                    <label for="nic">Condition :</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="condition" id="brand_new" value="brand new"<?php if (@$condition == "brand new") { ?>checked <?php } ?>>
                            <label class="form-check-label" for="brand_new">Brand New</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="condition" id="used" value="used"<?php if (@$condition == "used") { ?>checked <?php } ?>>
                            <label class="form-check-label" for="used">Used</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="condition" id="re-condition" value="re-condition"<?php if (@$condition == "re-condition") { ?>checked <?php } ?>>
                            <label class="form-check-label" for="re-condition">Re-Condition</label>
                        </div>
                    </div>
                    <div class="text-danger"><?php echo @$e['condition']; ?></div>
                </div>
                        
                    </div>
                    
                </div>
                <!--row-->
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="bt_price"  class="font-weight-bold" >Bought Price:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rs.</span>
                                </div>
                                <input type="number" step=".01" class="form-control" name="bt_price" id="bt_price" value="<?php echo $bt_price; ?>"name="unit_price" placeholder="Enter bought price">
                            </div>
                            <div class="text-danger"><?php echo @$e['bt_price']; ?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="bt_date">Bought Date:</label>
                            <input type="date" class="form-control" id="bt_date" name="bt_date" value="<?php echo @$bt_date; ?>">
                            <div class="text-danger"><?php echo @$e['bt_date']; ?></div>
                        </div>
                    </div>
                </div>
                <!--/.row-->

                


                <div class="form-group">
                    <label for="warranty">Warranty Period :</label>
                    <div class="input-group">
                        <input type="number" name="warranty" id="warranty" class="form-control" min="0" max="1200" placeholder="Enter warranty period in month" value="<?php echo @$warranty; ?>">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Months</span>
                        </div>
                    </div>
                    <div class="text-danger"><?php echo @$e['warranty']; ?></div>
                </div>
                <!--row-->
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="unit_cost"  class="font-weight-bold" >Unit Cost :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rs.</span>
                                </div>
                                <input type="number" step=".01" class="form-control" name="unit_cost" id="unit_cost" value="<?php echo $unit_cost; ?>" placeholder="Enter unit cost">
                            </div>
                            <div class="text-danger"><?php echo @$e['unit_cost']; ?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="service">Service period :</label>
                            <div class="input-group">
                                <input type="number" name="service" id="service" class="form-control" min="1" max="1200" placeholder="Enter service period in month" value="<?php echo @$service; ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Months</span>
                                </div>
                            </div>
                            <div class="text-danger"><?php echo @$e['service']; ?></div>
                        </div>
                    </div>
                </div>
                <!-- /.row-->

                <div class="form-group" >
                    <div id="result_type_load">
                        <?php
                        //filter supplier who supply each accessory type--------
                        $sql = "SELECT tb_supplier.supplier_id, tb_supplier.`com_nm` FROM tb_supplier_tool_group
                                LEFT JOIN tb_supplier ON tb_supplier_tool_group.supplier_id=tb_supplier.supplier_id";

                        $result_sup = $conn->query($sql);
                        ?>
                        <label for="supplier">Supplier :</label>
                        <select class="form-control select2" name="supplier" id="supplier" style="width: 100%;">
                            <option value="">Select existing Supplier</option>
                            <?php
                            if ($result_sup->num_rows > 0) {
                                while ($row_sup = $result_sup->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row_sup['supplier_id']; ?>"<?php if (@$sup_id == $row_sup['supplier_id']) { ?> selected<?php } ?> > <?php echo $row_sup['com_nm']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="text-danger"><?php echo @$e['supplier']; ?></div>
                </div>
                <!-- /.form-group -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">




                <?php if (@$_POST['operate'] != "edit") { ?>
                <button type="submit" name="operate" value="insert"   class="btn btn-primary">Next</button>
                <?php }
                ?>

                <?php
                if (@$_POST['operate'] == "edit") {
                    ?>
                    <input type="hidden" name="eqp_id" value="<?php echo $eqp_id; ?>" >  
                    <button type="submit" class="btn btn-primary"  name="operate" value="update" >Update</button>
                    <?php
                }
                ?>
                <button type="submit" name="operate" value="cancel" class="btn btn-info">Cancel</button>




            </div>

        </form>
    </div>

    <?php
//retrieve list product 
    $sql = "SELECT *
            FROM `tb_equipment`";


    if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "search") {
        //Define variables
        $brand_sh = $model_sh = null;
        //empty validation
        $brand_sh = clean_input($_POST['brand_sh']);
        $model_sh = clean_input($_POST['model_sh']);

        //advanced validation
        if (!empty($brand_sh)) {
            if (!preg_match("/^[a-zA-Z ]*$/", $brand_sh)) {
                $e['brand_sh'] = "The brand name is invalid...!";
            }
        }
        if (!empty($model_sh)) {
            if (!preg_match("/^[a-zA-Z0-9 ]*$/", $model_sh)) {
                $e['model_sh'] = "The model name is invalid...!";
            }
        }
        //search 
        if (empty($e)) {

            $sql = "SELECT `equipment_id`, group_code, `brand`, `model` FROM tb_equipment ";
            //switch case for search sql append
            switch (true) {
                case!empty($brand_sh) && !empty($model_sh):
                    $sql .= "WHERE `brand` LIKE '%$brand_sh%' AND `model` LIKE '%$model_sh%'";
                    break;
                case!empty($brand_sh):
                    $sql .= "WHERE `brand` LIKE '%$brand_sh%'";
                    break;
                case!empty($model_sh):
                    $sql .= "WHERE `model` LIKE '%$model_sh%'";
                    break;
            }
        }
    }
    $result_view = $conn->query($sql);
    ?>

    <div class="card card-primary">
        <!--header 2--> 
        <div class="card-header">
            <div class="col">
                <h3 class="card-title">Search</h3>
            </div>
        </div>
        <!--/.header 2-->
        <div class="card-body  ">
            <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> " >
                <div class="row">

                    <div class="form-group col">

                        <label for="brand_sh">Brand :</label>

                        <input type="text" class="form-control" id="brand_sh" name="brand_sh" value="<?php echo @$brand_sh; ?>" placeholder="Search brand" >
                        <div class="text-danger"><?php echo @$e['brand_sh']; ?></div>
                    </div>

                    <div class="form-group col">

                        <label for="model_sh">Model :</label>

                        <input type="text" class="form-control" id="model_sh" name="model_sh" placeholder="Search model" value="<?php echo @$model_sh; ?>">

                        <div class="text-danger"><?php echo @$e['model_sh']; ?></div>

                    </div>
                    <div col">
                        <div> <br></div>
                        <button class="btn btn-default " name="operate" type="submit" id="operate" value="search" onmouseover="this.style.color = '#17a2b8 '" onmouseout="this.style.color = '#383f45'">
                            <i class="fas fa-search fa-2x"></i>
                        </button>
                    </div>


                </div>

            </form>
        </div>
    </div>

    <!--view form-->
    <div class="container-fluid">

        <div class="card card-primary">

            <!--card header 2-->
            <div class="card-header">
                <h3 class="card-title">Equipment List</h3>
            </div> 
            <!-- /.card-header -->
            <div class="card-body">

                <table class="table table-hovers table-dark">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Status</th>
                            <th>function</th>
                            
                            <th></th>
                            <th></th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
//                        $product_id = $product_name = $description = $product_image = $task = null;
                        if ($result_view->num_rows > 0) {
                            while ($row = $result_view->fetch_assoc()) {
//                                $eqip_id = $row['product_id'];
//                                $eqip_brand = $row['name'];
//                                $product_image = $row['product_img'];
//                                $description = $row['discription'];
                                ?>
                                <tr>

                                    <td><?php echo $row['equipment_id']; ?></td>
                                    <td><?php
                                        $sql = "SELECT `group` FROM `tb_tool_group` WHERE group_code =" . $row['group_code'];
                                        $result = $conn->query($sql);
                                        while ($rowtp = $result->fetch_assoc()) {
                                            echo $rowtp['group'];
                                        }
                                        ?></td>
                                    <td><?php echo $row['brand']; ?></td>
                                    <td><?php echo $row['model']; ?></td>

                                    <td><?php echo $row['stat']; ?></td>
                                    <td>
                                        <div class="input-group-append" >
                                          
                                            <form method="post" action="function.php">
                                                <input type="hidden" name="eqp_id" value="<?php echo $row['equipment_id']; ?>" >
                                                <input type="hidden" name="tool_grp" value="<?php echo $row['group_code']; ?>" >
                                                <button type="submit" name="operate" value="property" class="btn btn-default" onmouseover="this.style.color = '#cc0e74'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-arrow-alt-circle-right" ></i></button>                   
                                            </form>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="input-group-append" >
                                            <form method="post" action="view.php">
                                                <input type="hidden" name="eqp_id"  id="eqp_id" value="<?php echo $row['equipment_id']; ?>" >
                                                <button type="submit" name="operate" value="view" class="btn btn-default" onmouseover="this.style.color = '#05dfd7'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-eye" ></i></button>                   
                                            </form>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="input-group-append">
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                                                <input type="hidden" name="eqp_id" value="<?php echo $row['equipment_id']; ?>" >
                                                <button type="submit" name="operate" value="edit" class="btn btn-default" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-edit" ></i></button>                   
                                            </form>
                                        </div>

                                    </td>
                                    <td>
                                        <form method="post" action="delete.php">
                                            <input type="hidden" name="eqp_id" value="<?php echo $row['equipment_id']; ?>">
                                            <button type="submit" name="operate" value="delete" class="btn btn-default" onmouseover="this.style.color = '#ff1a1a'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-trash-alt" ></i></button>         
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include '../footer.php'; ?>
<?php ob_end_flush(); ?>
<script type="text/javascript">
    function loadPoperty(load_type) {
        var mydata = "load_type=" + load_type + "&";
//   alert(mydata);
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "type_load_combo.php",
            success: function (data) {
                $("#result_type_load").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
</script>