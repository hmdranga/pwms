<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "view") {
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
<div class="row">
    &nbsp;  
    <a href="add.php">
        <button type="button" class="btn btn-group-lg" onmouseover="this.style.color = '#83a95c'" onmouseout="this.style.color = '#383f45'">
            <i class="fas fa-arrow-alt-circle-left fa-lg" ></i>
        </button>
    </a>               
    <form method="post" action="add.php">
        <input type="hidden" name="eqp_id" value="<?php echo $eqp_id; ?>">
        <button type="submit" name="operate" value="edit" class="btn btn-group-lg" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'">
            <i class="fas fa-edit" ></i>
        </button>                   
    </form>
    <form method="post" action="delete.php">
        <input type="hidden" name="eqp_id" value="<?php echo $eqp_id; ?>">
        <button type="submit" name="operate" value="delete" class="btn btn-group-lg" onmouseover="this.style.color = '#ff1a1a'" onmouseout="this.style.color = '#383f45'">
            <i class="fas fa-trash-alt" ></i>
        </button>         
    </form>
</div>
<table class="table table-bordered bg-white table-striped">
    <tr>
        <td style="width:20%"><b>Equipment ID :</b></td>
        <td><?php echo"0000". $eqp_id; ?></td>
    </tr>
    <tr>
        <td><b>Tool Type :</b></td>
        <td><?php
            $sql = "SELECT `group` FROM `tb_tool_group` WHERE group_code =" . $tool_grp;
            $result = $conn->query($sql);
            while ($rowtp = $result->fetch_assoc()) {
                echo $rowtp['group'];
            }
            ?></td>
    </tr>
    <tr>
        <td><b>Brand :</b></td>
        <td><?php echo $brand; ?></td>
    </tr>

    <tr>
        <td><b>Model :</b></td>
        <td> <?php echo $model; ?> </td>
    </tr>
    <tr>
        <td><b>Function & Properties :</b></td>
        <td><?php
            $sql = "SELECT `function_id`,`name` 
                FROM `tb_tool_function` 
                WHERE `function_id` 
                IN( SELECT tb_function_property.function_id 
                    FROM `tb_equipment_property_value` 
                    LEFT JOIN tb_function_property 
                    ON tb_function_property.function_property_id = tb_equipment_property_value.function_property_id 
                    WHERE tb_equipment_property_value.equipment_id = $eqp_id )";
            $result = $conn->query($sql);
            while ($rowepv = $result->fetch_assoc()) {
                echo "<b>" . $rowepv['name'] . "</b> : ";

                $sql = "SELECT `property`,property_id
                    FROM `tb_product_property` 
                    WHERE `property_id` 
                    IN( SELECT tb_function_property.property_id 
                    FROM `tb_equipment_property_value` 
                    LEFT JOIN tb_function_property 
                    ON tb_function_property.function_property_id = tb_equipment_property_value.function_property_id 
                    WHERE tb_equipment_property_value.equipment_id = $eqp_id
                    AND tb_function_property.function_id = " . $rowepv['function_id'] . ")";
                $resultprop = $conn->query($sql);
                while ($rowprop = $resultprop->fetch_assoc()) {
                    echo"<br>";
                    echo $rowprop['property'] . " (";

                    $sql = "SELECT `property_value_id`, `property_id`, `value` 
                       FROM `tb_product_property_value` 
                       WHERE property_value_id 
                       IN( SELECT `property_value_id` 
                           FROM `tb_equipment_property_value` 
                           LEFT JOIN tb_function_property 
                           ON tb_function_property.function_property_id = tb_equipment_property_value.function_property_id 
                           WHERE `equipment_id` = $eqp_id
                           AND tb_function_property.function_id =" . $rowepv['function_id'] . ")
                       AND property_id=" . $rowprop['property_id'] . "
                       ORDER BY `tb_product_property_value`.`value` ASC";
                    $resultpropval = $conn->query($sql);
                    $finalrowpropval = null;
                    while ($rowpropval = $resultpropval->fetch_assoc()) {
                        $finalrowpropval .= $rowpropval['value'] . " , ";
                    }
                    $finalrowpropval = rtrim($finalrowpropval, ", "); // last comma remove 
                    echo $finalrowpropval;
                    echo")";
                }
                echo"<br>";
            }
            ?></td>
    </tr>

    <tr>
        <td><b>Manufacture Date :</b></td>
        <td><?php echo $mn_date; ?></td>
    </tr>
    <tr>
        <td><b>Bought Price :</b></td>
        <td><?php echo "Rs. " . $bt_price; ?></td>
    </tr>
    <tr>
        <td><b>Bought Date :</b></td>
        <td><?php echo $bt_date; ?></td>
    </tr>
    <tr>
        <td><b>Bought Condition :</b></td>
        <td><?php echo $condition; ?></td>
    </tr>
    <tr>
        <td><b>Warranty Period :</b></td>
        <?php
        $exp_date = new DateTime($bt_date);
        $exp_date->add(new DateInterval('P' . $warranty . 'M'));
        $exp_date->format('Y-m-d');
        $date_now = date("Y-m-d");
        ?>
        <td style="<?php if ($date_now > $exp_date->format('Y-m-d')) {
            echo "background-color:#d57149";//expired 
        } else {
            echo"background-color:#4e8d7c";
        } ?>"> <?php echo $warranty . " Months"; ?>
<?php
echo "<br>   Expire Date : " . $exp_date->format('Y-m-d');
?>
        </td>
    </tr>
<!--    <tr>
        <td>Unit Cost :</td>
        <td><?php // echo "Rs. ".$unit_cost;  ?></td>
    </tr>-->
    <tr>
        <td><b>Service period :</b></td>
        <?php
        $sql = "SELECT  `service_date` FROM `tb_equipment_service` 
                WHERE `eqp_id` =" . $eqp_id . " 
                ORDER BY `tb_equipment_service`.`service_date` DESC 
                LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               $lst_servie = $row['service_date'];// last service
            }
            $nxt_service = new DateTime($lst_servie); 
        } elseif ($result->num_rows == 0) {
            $nxt_service = new DateTime($bt_date);
        }
          $nxt_service ->add(new DateInterval('P'.$service.'M'));
        ?>
        <td
            style="<?php if ($date_now > $nxt_service->format('Y-m-d')) {
            echo "background-color:#b3504b";//have to service 
        } else {
            echo"background-color:#4e8d7c";
        } ?>"
            >
        <?php 
        echo $service . " Months";
        echo "<br>Next Service : ".$nxt_service->format('Y-m-d');
        ?>
        </td>

    </tr>
    <tr>
        <td><b>Supplier :</b></td>
        <td><?php
            $sql = "SELECT  `com_nm`, `address` FROM `tb_supplier` WHERE `supplier_id`=" . $sup_id;
            $result = $conn->query($sql);
            while ($rowsp = $result->fetch_assoc()) {
                echo"Company name : " . $rowsp['com_nm'];

                echo"<br> Address : " . $rowsp['address'];
            }
            ?></td>
    </tr>

</table>
