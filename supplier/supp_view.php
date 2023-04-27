<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "view") {
    $supplier_id = $com_nm = $address = $div_sec = $con_pnm = $tp_no = $email = $web = $bnk_nm = $bnk_acc = $s_type = $sup_cat = null;
    $supplier_id = $_POST['supplier_id'];

    $sql = "SELECT * FROM `tb_supplier` WHERE supplier_id = $supplier_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
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
    }
}
?>
<div class="row">
    &nbsp;  
    <a  href="register.php"><button type="button" class="btn btn-group-lg" onmouseover="this.style.color = '#83a95c'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-arrow-alt-circle-left fa-lg" ></i></button></a>               
    <form method="post" action="register.php">
        <input type="hidden" name="supplier_id" value="<?php echo $supplier_id; ?>">
        <button type="submit" name="operate" value="edit" class="btn btn-group-lg" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-edit"></i></button>    
    </form>
    <form method="post" action="supp_dlt.php">
        <input type="hidden" name="supplier_id" value="<?php echo $supplier_id; ?>">

        <button type="submit" name="operate" value="delete" class="btn btn-group-lg" onmouseover="this.style.color = '#ff1a1a'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-trash-alt" ></i></button>         
    </form>
</div>
<table class="table table-bordered bg-gray-dark table-striped">
    <tr>
        <td style="width:25%">Supplier commercial name :</td>
        <td><?php echo $com_nm; ?></td>
    </tr>
    <tr>
        <td>Supply Accessory type :</td>
        <td>
            <?php
            $sql = "SELECT `name` FROM `tb_accessory_type` WHERE  `accessory_type_id` IN(SELECT `accessory_type_id` FROM `tb_suplier_accessory_type` WHERE `supplier_id` = $supplier_id )";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $type[] = $row['name'];
                }

                foreach ($type as $value) {

                    echo $value . ",";
                    echo "<br>";
                }

                $type = null;
            } else {
                echo "--";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>Supply Tool type  :</td>
        <td>
            <?php
            $sql = "SELECT `group` FROM `tb_tool_group` WHERE `group_code` IN(SELECT  `group_code` FROM `tb_supplier_tool_group` WHERE `supplier_id` = $supplier_id )";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $type[] = $row['group'];
                }
                foreach ($type as $value) {

                    echo $value . ",";
                    echo "<br>";
                }
                $type = null;
            } else {
                echo "--";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>Address :</td>
        <td><?php echo $address; ?></td>
    </tr>
    <tr>
        <td>Divisional Sector :</td>
        <td><?php
            $sql = "SELECT `DivSecretariat` FROM `tb_divsecretariat` WHERE `DivSec_Code`= '$div_sec'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo $row['DivSecretariat'];
                }
            }
            ?></td>
    </tr>
    <tr>
        <td>Contact person :</td>
        <td><?php echo $con_pnm; ?></td>
    </tr>
    <tr>
        <td>Telephone No :</td>
        <td><?php echo $tp_no; ?></td>
    </tr>
    <tr>
        <td>Email :</td>
        <td><?php echo $email; ?></td>
    </tr>
    <tr>
        <td>Official Website :</td>
        <td><a href="<?php echo $web; ?>"  target="_blank"><?php echo $web; ?></a></td>
    </tr>
    <tr>
        <td>Bank Account:</td>
        <td><?php echo $bnk_nm . " : " . $bnk_acc; ?></td>
    </tr>

</table>

<?php
$sql_view = "SELECT * FROM `tb_stock` WHERE supplier_id = $supplier_id ORDER BY `tb_stock`.`pur_date` DESC";
$result_view = $conn->query($sql_view);
?>

<div class="card card-primary">
    <!--card header -->
    <div class="card-header">
        <div class="row">
            <div class="col">
                <h3 class="card-title">Supply Accessory History</h3>
            </div>
            <div class="col">
                <?php
                echo"Transaction count : " . $result_view->num_rows;
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
                        <th>Purchase Date</th>
                        <th>Stock ID</th>
                        <th>Accessory</th>
                        <th>Qty</th>
                        <th>Unit Cost</th>
                        <th>Expire Date</th>
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
                                <td><?php echo $row['pur_date']; ?></td>
                                <td><?php echo $row['stock_id']; ?></td>
                                <td><?php
                                    $sql = "SELECT tb_accessory_type.name, tb_product_property_value.value FROM tb_accessory 
                                            LEFT JOIN tb_accessory_type  ON tb_accessory_type.accessory_type_id = tb_accessory.accessory_type_id
                                            LEFT JOIN tb_accessory_property ON tb_accessory.accessory_id = tb_accessory_property.accessory_id 
                                            LEFT JOIN tb_product_property_value ON tb_accessory_property.property_value_id=tb_product_property_value.property_value_id 
                                            WHERE tb_accessory_property.accessory_id = " . $row['accessory_id'];
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row_prop = $result->fetch_assoc()) {

                                            $acc_type = $row_prop['name'];
                                            $val[] = $row_prop['value'];
                                        }
                                        echo $acc_type . "(";

                                        foreach ($val as $value) {
                                            echo $value . " ,";
                                        }
                                        echo ")";
                                        $val = $acc_type = null;
                                    } else {
                                        echo "--";
                                    }
                                    ?></td> 
                                <td><?php echo $row['qty']; ?></td>
                                <td><?php echo "Rs. " . $row['unit_price']; ?></td>
                                <td><?php echo $row['ex_date']; ?></td>
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
    <?php
    $sql_eqp_view = "SELECT * FROM `tb_equipment` WHERE supplier_id = $supplier_id ORDER BY `tb_equipment`.`bought_date` DESC";
    $result_eqp_view = $conn->query($sql_eqp_view);
    ?>
    <div class="card-header">
        <div class="row">
            <div class="col">
                <h3 class="card-title">Supply Equipment History</h3>
            </div>
            <div class="col">
                <?php
                echo"Transaction count : " . $result_eqp_view->num_rows;
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
                        <th>Purchase Date</th>
                        <th>Equipment ID</th>
                        <th>Type</th>
                        <th>Function</th>
                        <th>Brand</th>
                        <th>Model</th>                       
                        <th>Bought Price</th>

                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_eqp_view->num_rows > 0) {
                        while ($row = $result_eqp_view->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['bought_date']; ?></td>
                                <td><?php echo $row['equipment_id']; ?></td>
                                <td><?php
                    $sql_grp = "SELECT `group` FROM `tb_tool_group` WHERE `group_code`=" . $row['group_code'];
                    $result_grp = $conn->query($sql_grp);
                    while ($row_grp = $result_grp->fetch_assoc()) {
                        echo $row_grp['group'];
                    }
                            ?></td> 
                                <td><?php
                                    $sql = "SELECT `name` FROM `tb_tool_function` 
                                        WHERE `function_id` 
                                        IN(SELECT function_id FROM tb_function_property WHERE function_property_id 
                                        IN (SELECT function_property_id FROM tb_equipment_property_value WHERE equipment_id = " . $row['equipment_id'] . "))";
                                    $result = $conn->query($sql);
                                    while ($row_func = $result->fetch_assoc()) {
                                        echo $row_func['name'] . "(), ";
                                    }
                                    ?></td>
                                <td><?php echo $row['brand']; ?></td>
                                <td><?php echo $row['model']; ?></td>
                                <td><?php echo "Rs. " . $row['bought_price']; ?></td>
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