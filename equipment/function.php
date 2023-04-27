<!--
Page Name: assign.php(equipment)
Date Created :06/10/2020
-->
<?php ob_start(); ?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//Check Page Request Method
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "property")) {

    //Define variables
    $eqp_id = $tool_grp = null;

    //define arry for display error messages
    $e = array();

    //Assign Data--------------------------------------
    $eqp_id = @$_SESSION['emp_id'] ;
    $tool_grp = @$_SESSION['tool_grp'];
    $eqp_id = $_POST['eqp_id'];
    $tool_grp = $_POST['tool_grp'];
}


//this page assign form assign button submition
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "assign")) {
    // print_r($_POST);
    //Define variables
    $eqp_id = $tool_grp = $prop_val = null;

    //define arry for display error messages
    $e = array();

    //Assign Data--------------------------------------
    echo $_POST['unit_cost'];
    $eqp_id = $_POST['eqp_id'];
    $tool_grp = $_POST['tool_grp']; //for content of the page
    if (isset($_POST['prop_val'])) {
        $prop_val = $_POST['prop_val']; //passes property_value_id and function_property_id
    }
    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($prop_val)) {
        $e['prop_val'] = "Values should not be empty....!";
    }
    //End check input fields are empty-----------------

    if (empty($e)) {
        foreach ($prop_val as $packge) {
            //separate property_value_id and function_property_id
            $arr_val = explode('#', $packge);
            $arr_val[0]; //property_value_id
            $arr_val[1]; //function_property_id

            $sql = "SELECT `equipment_property_value_id`, `equipment_id`, `function_property_id`, `property_value_id` 
                         FROM `tb_equipment_property_value` 
                         WHERE `equipment_id`= '$eqp_id' AND function_property_id = '$arr_val[1]' AND property_value_id = '$arr_val[0]'";
            $result = $conn->query($sql);

            if ($result->num_rows == 0) {


                $sql = "INSERT INTO `tb_equipment_property_value`( `equipment_id`, `function_property_id`, `property_value_id`) 
                        VALUES ('$eqp_id','$arr_val[1]','$arr_val[0]')";
                if ($conn->query($sql) === true) {
//                $prop_val = null
//                
                    ?>

                    <div class="alert alert-success alert-dismissible fade_show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Success! Equipment properties assigned.. </strong>
                    </div>

                    <?php
                } else {
                    echo "Error" . $conn->error;
                }
            } else {
                ?>
                <div class="alert alert-danger alert-dismissible fade_show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong> Selected equipment property already in database.. </strong>
                </div>
                <?php
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "deny")) {



    //Define variables
    $eqp_id = $tool_grp = $prop_val = null;

    //define arry for display error messages
    $e = array();

    //Assign Data--------------------------------------
    $eqp_id = $_POST['eqp_id'];
    $tool_grp = $_POST['tool_grp']; //for content of the page
    if (isset($_POST['prop_val'])) {
        $prop_val = $_POST['prop_val']; //passes property_value_id and function_property_id
    }

    //Check input fields are empty---------------------
    if (empty($prop_val)) {
        $e['prop_val'] = "Values should not be empty....!";
    }
    //End check input fields are empty-----------------
    if (empty($e)) {
        foreach ($prop_val as $packge) {
            //separate property_value_id and function_property_id
            $arr_val = explode('#', $packge);
            $arr_val[0]; //property_value_id
            $arr_val[1]; //function_property_id

            $sql = "SELECT `equipment_property_value_id`, `equipment_id`, `function_property_id`, `property_value_id` 
                         FROM `tb_equipment_property_value` 
                         WHERE `equipment_id`= '$eqp_id' AND function_property_id = '$arr_val[1]' AND property_value_id = '$arr_val[0]'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {


                $sql = "DELETE FROM `tb_equipment_property_value` WHERE `equipment_id`= '$eqp_id' AND function_property_id = '$arr_val[1]' AND property_value_id = '$arr_val[0]'";
                if ($conn->query($sql) === true) {
                    ?>

                    <div class="alert alert-success alert-dismissible fade_show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Deny! Equipment properties denied.. </strong>
                    </div>

                    <?php
                } else {
                    echo "Error" . $conn->error;
                }
            } else {
                ?>
                <div class="alert alert-danger alert-dismissible fade_show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong> Selected Equipment properties not in database.. </strong>
                </div>

                <?php
            }
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "edit")) {



    //Define variables
    $eqp_id = $tool_grp = $prop_val = null;

    //define arry for display error messages
    $prop_val = array();

    //Assign Data--------------------------------------
    $eqp_id = $_POST['eqp_id'];
    $tool_grp = $_POST['tool_grp']; //for content of the page
    //separate property_value_id and function_property_id
    //$arr_val = explode('#', $packge);
    //$arr_val[0]; //property_value_id
    //$arr_val[1]; //function_property_id

    $sql = "SELECT `equipment_property_value_id`, `equipment_id`, `function_property_id`, `property_value_id` 
                         FROM `tb_equipment_property_value` 
                         WHERE `equipment_id`= '$eqp_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $val = $row['property_value_id'] . "#" . $row['function_property_id'];

            array_push($prop_val, $val);
        }
    } else {
        echo "Error" . $conn->error;
    }
}

//sql for select
//$sql_view = "SELECT `group_code`, `group` FROM `tb_tool_group`";
//$result_view = $conn->query($sql_view);
?>
<div class="row">
    <a  href="add.php"><button type="button" class="btn btn-lg" onmouseover="this.style.color = '#83a95c'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-arrow-alt-circle-left fa-lg" ></i></button></a>               
</div>
<div class="container-fluid">
    <div class="card card-primary ">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h3 class="card-title">Step 02 : Equipment Register - Property Assign</h3> 
                </div>
                <!--                <div class="col"></div>-->
                <div class="col"><?php
                    $sql = "SELECT `function_id`,`name` FROM `tb_tool_function` WHERE `function_id` IN( SELECT tb_function_property.function_id FROM `tb_equipment_property_value` LEFT JOIN tb_function_property ON tb_function_property.function_property_id = tb_equipment_property_value.function_property_id WHERE tb_equipment_property_value.equipment_id = $eqp_id )";
                    $result = $conn->query($sql);
                    while ($rowepv = $result->fetch_assoc()) {
                        echo "<b>" . $rowepv['name'] . "</b> : ";

                        $sql = "SELECT `property`,property_id
                    FROM `tb_product_property` 
                    WHERE `property_id` 
                    IN( SELECT tb_function_property.property_id 
                    FROM `tb_equipment_property_value` 
                    LEFT JOIN tb_function_property ON tb_function_property.function_property_id = tb_equipment_property_value.function_property_id 
                    WHERE tb_equipment_property_value.equipment_id = $eqp_id AND tb_function_property.function_id = " . $rowepv['function_id'] . ")";
                        $resultprop = $conn->query($sql);
                        while ($rowprop = $resultprop->fetch_assoc()) {
                            echo"<br>";
                            echo $rowprop['property'] . " (";

                            $sql = "SELECT `property_value_id`, `property_id`, `value` FROM `tb_product_property_value` WHERE property_value_id IN( SELECT `property_value_id` FROM `tb_equipment_property_value` LEFT JOIN tb_function_property ON tb_function_property.function_property_id = tb_equipment_property_value.function_property_id WHERE `equipment_id` = $eqp_id AND tb_function_property.function_id =" . $rowepv['function_id'] . ") AND property_id=" . $rowprop['property_id'] . " ORDER BY `tb_product_property_value`.`value` ASC";
                            $resultpropval = $conn->query($sql);
                            while ($rowpropval = $resultpropval->fetch_assoc()) {
                                echo $rowpropval['value'] . " , ";
                            }
                            echo")";
                        }
                        echo"<br>";
                    }
                    ?>
                </div>                
            </div>
        </div>
        <!-- /.card-header -->
        <form role="form" method="post"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="card-body">
                <div class="form-group" >
                    <?php
                    //each function belongs to each tool
                    $sql_func = "SELECT  tb_tool_group_function.`function_id`, tb_tool_function.name 
                            FROM `tb_tool_group_function` 
                            LEFT JOIN tb_tool_function ON tb_tool_function.function_id = tb_tool_group_function.function_id 
                            WHERE `group_code`= $tool_grp";
                    $result_func = $conn->query($sql_func);
                    ?>
                    <!--                    <label for="tool_func">Tool Function :</label> -->
                    <!------------------------------------------error display---------------------------------------------------------------------------------------------->
                    <div class="text-danger"><?php echo @$e['prop_val']; ?></div>
                    <div class="text-danger"><?php echo @$e['err']; ?></div>
                    <?php
                    if ($result_func->num_rows > 0) {
                        while ($row_func = $result_func->fetch_assoc()) {
                            ?>
                            <!--<br>-->     
                            <i><label for="tool_func"><?php echo $row_func['name'] . "   "; ?></label></i>
                            <div class="spinner-grow spinner-grow-sm"></div>
                            <i class="fas fa-arrow-right"></i>
                            <div class="row">
                                <?php
                                //each property belongs to each function
                                $sql_prop = "SELECT tb_function_property.function_property_id, tb_product_property.`property_id`, tb_product_property.property 
                                         FROM `tb_function_property`
                                         LEFT JOIN tb_product_property ON tb_function_property.property_id = tb_product_property.property_id 
                                         WHERE `function_id`=" . $row_func['function_id'];
                                $result_prop = $conn->query($sql_prop);
                                if ($result_prop->num_rows > 0) {
                                    while ($row_prop = $result_prop->fetch_assoc()) {
                                        ?>
                                        <!--property column-->
                                        <div class="col">
                                            <?php $func_prop_id = $row_prop['function_property_id']; ?>
                                            <label for="prop"><?php echo $row_prop['property'] . "   "; ?></label>
                                            <br>
                                            <?php
                                            //each value belongs to each property
                                            $sql_pro_val = "SELECT `property_value_id`, `value` 
                                                   FROM `tb_product_property_value` 
                                                   WHERE `property_id` = '" . $row_prop['property_id'] . "' ORDER BY `tb_product_property_value`.`value` ASC";
                                            $result_pro_val = $conn->query($sql_pro_val);
                                            if ($result_pro_val->num_rows > 0) {
                                                while ($row_pro_val = $result_pro_val->fetch_assoc()) {
                                                    $pak = $row_pro_val['property_value_id'] . "#" . $func_prop_id;
                                                    ?>
                                                    <!--dynamically arrange property value check box-->
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="<?php echo $pak; ?>" id="<?php echo $pak; ?>" name="prop_val[]" 
                                                        <?php
                                                        if (!empty($prop_val)) {
                                                            if (in_array($pak, @$prop_val)) {
                                                                ?>
                                                                       checked
                                                                       <?php
                                                                   }
                                                               }
                                                               ?> >
                                                        <label class="form-check-label" for="<?php echo $pak; ?>" >
                                                            <?php echo $row_pro_val['value']; ?>
                                                        </label>
                                                    </div>
                                                    <!--//for cost input-->
                                                    <?php
//                                                    if (!empty($prop_val)) {
//                                                        if (in_array($pak, @$prop_val)) {
                                                            ?>
                                                            <div>
                                                                <input type="number" step=".01" class="form-control" name="unit_cost" id="unit_cost" value="<?php echo $unit_cost; ?>" placeholder="Enter Unit Cost" style="width:150px" type="hidden">
                                                            </div>
                                                        <?php
//                                                        }
//                                                    }
                                                    ?>

                                                    <!--//cost input end-->
                                                    <?php
                                                }
                                            } else {
                                                $e['err'] = "plese check Tool-group Function Assign..";
                                            }
                                            ?>
                                        </div>   
                                        <?php
                                    }
                                } else {
                                    $e['err'] = "plese check Tool Function Property Assign..";
                                }
                                ?>
                            </div>
                            <br>
                            <?php
                        }
                    } else {
                        $e['err'] = "plese check Tool-group Function Assign..";
                    }
                    ?>
                </div>
            </div>      

            <!-- /.card-body -->
            <div class="card-footer">
                <div class="row">
                    <div class="col">

                        <input type="hidden" name="eqp_id" value="<?php echo $eqp_id; ?>" >
                        <input type="hidden" name="tool_grp" value="<?php echo $tool_grp; ?>" >   
                        <button type="submit" name="operate" value="assign" class="btn btn-primary">Assign</button>

                    </div>

                    <div class="col">

                        <button type="submit" name="operate" value="edit" class="btn btn-secondary">Edit  <i class="fas fa-edit" ></i></button>
                    </div>
                    <div class="col">

                        <button type="submit" name="operate" value="property" class="btn btn-info">Cancel</button>
                    </div>
                    <div class="col">


                        <button type="submit" name="operate" value="deny" onclick="" class="btn btn-danger" >Deny<i class="fas fa-trash-alt" ></i></button>

                    </div>

                </div>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</div>
</div>

<?php include '../footer.php'; ?>
<?php ob_end_flush(); ?>
<script type="text/javascript">

</script>
