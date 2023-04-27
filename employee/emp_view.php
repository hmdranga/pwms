
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "view") {
    $emp_id = $f_nm = $l_nm = $address = $tp_no = $email = $nic = $pro_pic = $gender = $cvl_stat = $reg_date = $desig = $regi_persn = $skill = null;
    $emp_id = $_POST['emp_id'];

    $sql = "SELECT * FROM `tb_employee` WHERE employee_id = $emp_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
                    $f_nm = $row['first_name'];
                    $l_nm = $row['last_name'];
                    $address = $row['address'];
                    $tp_no = $row['tp_no'];
                    $email = $row['email'];
                    $nic = $row['nic'];
                    $pro_pic = $row['pro_pic'];
                    $gender = $row['gender'];
                    $cvl_stat = $row['civil_status'];
                    $reg_date = $row['reg_date'];
                    $desig = $row['desig'];
                    $regi_persn = $row['reg_person'];
                    $status = $row['status'];
                   
        }
    }
}
?>
<div class="row" >
    &nbsp;  
    <a  href="register.php"><button type="button" class="btn btn-group-lg" onmouseover="this.style.color = '#83a95c'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-arrow-alt-circle-left fa-lg" ></i></button></a>               
    <form method="post" action="register.php">
        <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?> " >
        <button type="submit" name="operate" value="edit" class="btn btn-group-lg" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-edit"></i></button>    
    </form>
    <form method="post" action="emp_dlt.php">
        <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
        <button type="submit" name="operate" value="delete" class="btn btn-group-lg" onmouseover="this.style.color = '#ff1a1a'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-trash-alt" ></i></button>         
    </form>
</div>
<table class="table table-bordered bg-white table-striped">
    <tr>
        <td ><b>profile picture :</b></td>
        <td><img src="<?php echo ROOT; ?>images/<?php echo $pro_pic; ?>" alt="profille pic" class=" img-rounded" style="opacity: .9" width="200" height="180"></td>
    </tr>
        <tr>
        <td ><b>Designation :</b></td>
        <td><?php
        $sql = "SELECT  `designation` FROM `tb_designation` WHERE `designation_id`= '$desig'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo $row['designation'];
                }
            }else{
                echo "--";
            }
         ?></td>
    </tr>
    <tr>
        <td ><b>Skills :</b></td>
        <td><?php
        
            $sql = "SELECT `skill` FROM `tb_skill` WHERE  `skill_id` IN(SELECT `skill_id` FROM `tb_employee_skill` WHERE `emp_id` = $emp_id )";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $skill[] = $row['skill'];
                }

                foreach ($skill as $value) {

                    echo $value . ",";
                    echo "<br>";
                }

                $skill = null;
            } else {
                echo "--";
            }
            ?></td>
    </tr>
    <tr>
        <td style="width:25%"><b>Employee Name :</b></td>
        <td><?php echo $f_nm." ".$l_nm; ?></td>
    </tr>
    
    <tr>
        <td><b>Address :</b></td>
        <td> <?php echo $address; ?> </td>
    </tr>
    <tr>
        <td><b>Telephone No :</b></td>
        <td><?php echo $tp_no; ?></td>
    </tr>
    <tr>
        <td ><b>email :</b></td>
        <td><?php echo $email; ?></td>
    </tr>
    <tr>
        <td ><b>NIC :</b></td>
        <td><?php echo $nic; ?></td>
    </tr>
    <tr>
        <td ><b>Gender :</b></td>
        <td><?php
        $sql = "SELECT `gender` FROM `tb_gender` WHERE `gender_id`= '$gender'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo $row['gender'];
                }
            }
        
         ?></td>
    </tr>
    <tr>
        <td ><b>Civil Status :</b></td>
        <td><?php
        $sql = "SELECT `civil_status` FROM `tb_civil_status` WHERE `civil_status_id`= '$cvl_stat'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo $row['civil_status'];
                }
            }
         ?></td>
    </tr>
    <tr>
        <<td><b>Registration Date :</b></td>
        <td>
            <?php echo $reg_date; ?>
        </td>
    </tr>
    <tr>
        <td><b>Registered Person :</b></td>
        <td>
            <?php echo "Dinath Udayantha (Manager)";// $regi_persn; ?>
        </td>
    </tr>
    <tr>
        <td><b>Status :</b></td>
        <td><?php echo "Active";//if($status=="A"){ echo "Active"; }else{echo "Deactive";}?></td>
    </tr>
    
   

</table>

<?php
//$sql_view = "SELECT * FROM `tb_stock` WHERE supplier_id = $supplier_id ORDER BY `tb_stock`.`pur_date` DESC";
//$result_view = $conn->query($sql_view);
?>

<div class="card card-primary">
    <!--card header -->
    <div class="card-header">
        <div class="row">
            <div class="col">
                <h3 class="card-title">Employee working History</h3>
            </div>
            <div class="col">
                <?php
//                echo"Order count : " . $result_view->num_rows;
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
                        <th></th>
                        <th>Order ID</th>
                        <th>Task</th>
                        <th>Customer Review</th>
                        <th>Manager Review</th>
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
    <!--./card-body-->
</div>
<!--/.card card-primary-->
<?php include '../footer.php'; ?>