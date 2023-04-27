<!--
Page Name: register.php(employee)
Date Created :28/06/2020
-->
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
print_r($_POST);
//Check Page Request Method 
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "insert")) {
    //Define variables
    $order_id = $amount = $new_amount = $new_stat = $stat = $pro_id = $qty = $today_time = null;
    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------
    $order_id = $_POST['order_id'];
    @$pro_id = $_POST['pro_id'];
    @$qty = $_POST['qty'];
    @$amount = clean_input($_POST['amount']);
    @$stat = $_POST['stat'];
    $today = date("Ymd");
    if ($stat == "PRO") {
        $max = $_POST['max'];
    }

    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($order_id)) {
        $e['order_id'] = "The Order Id should not be empty....!";
    }
    if (empty($amount)) {
        $e['amount'] = "The Amount should not be empty....!";
    }

    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($amount)) {

        if (!is_numeric($amount)) {
            $e['amount'] = "The Amount input should be number...!";
        }
        if (0 >= $amount) {
                $e['amount'] = "The amount input should not be positive!";
            }
        //max amount validation
        if ($stat == "PRO") {
            if ($max < $amount) {
                $e['amount'] = "The amount input should not be over maximum payment of Rs. " . $max . "  !";
            }
        }
    }
    //End advance validation----------------------------------------------------



//    $e = 1;
    if (empty($e)) {

        //process-------------------------------------------------------------------

        if ($stat == "PRE") {
            $new_stat = "PRO";
            $pay_status = "ADV";
            $new_amount = $amount;
        } elseif ($stat == "PRO") {

            $new_stat = "PRO";
            $pay_status = "ADV+";

            $sql_pay = "SELECT SUM(amount) as total
                    FROM tb_payment
                    WHERE order_id = $order_id";
            $result = $conn->query($sql_pay);
            if ($result->num_rows > 0) {
                $row_pay = $result->fetch_assoc();
                echo $new_amount = $row_pay['total'] + $amount;
            }
        } elseif ($stat == "FIN") {
            $new_amount = $amount;
            $pay_status = "FULL";
            $new_stat = "DONE";
        }

        //end process---------------------------------------------------------------
        //data send to database-----------------------------------------------------

        if ($stat == "PRE") {

            $sql_odr_acc = "SELECT * FROM `tb_order_acc`  WHERE order_id = $order_id";
            $result_odr_acc = $conn->query($sql_odr_acc);
            if ($result_odr_acc->num_rows > 0) {
                while ($row_odr_acc = $result_odr_acc->fetch_assoc()) {
                   
                    stock_use($row_odr_acc['acc_id'],$row_odr_acc['amont'],$order_id);

                }
            }

        }
            
            
            
        echo $sql = "UPDATE `tb_order` SET `order_status`= '$new_stat',`advance_payment` = '$new_amount' WHERE `order_id` = '$order_id'";
        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade_show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! Order Updated..</strong>
            </div>
            <?php
            $sqlpaymt = "INSERT INTO `tb_payment`( `amount`, `date`, `order_id`, `employee_id`, `pay_stat`) VALUES('$amount','$today','$order_id','" . $_SESSION['user_id'] . "','$pay_status')";
            if ($conn->query($sqlpaymt) == true) {
                ?>
                <div class="alert alert-success alert-dismissible fade_show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Order Payment Inserted..</strong>
                </div>
                <?php
            } else {
                echo "Error " . $conn->error;
            }

            $emp_id = $f_nm = $l_nm = $address = $tp_no = $email = $nic = $pro_pic = $gender = $cvl_stat = $reg_date = $desig = $regi_persn = $skill = null;
        } else {
            echo "Error" . $conn->error;
        }
    }
//    end data send to database------------------------------
}
?>
<?php
//Check Page Request Method and data edit 
//if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "edit") {
//    //Define variables
//    $emp_id = $f_nm = $l_nm = $address = $tp_no = $email = $nic = $pro_pic = $gender = $cvl_stat = $reg_date = $desig = $regi_persn = $skill = $cv = null;
//
//    $skill = array();
//    $emp_id = $_POST['emp_id'];
//    $sql_edit = "SELECT * FROM `tb_employee` WHERE `employee_id`='$emp_id'";
//    $result_edit = $conn->query($sql_edit);
//    if ($result_edit->num_rows > 0) {
//        while ($row = $result_edit->fetch_assoc()) {
//            $f_nm = $row['first_name'];
//            $l_nm = $row['last_name'];
//            $address = $row['address'];
//            $tp_no = $row['tp_no'];
//            $email = $row['email'];
//            $nic = $row['nic'];
//            $pro_pic = $row['pro_pic'];
//            $cv = $row['cv'];
//            $gender = $row['gender'];
//            $cvl_stat = $row['civil_status'];
//            $desig = $row['desig'];
//        }
//    }
//    $sql_edit = "SELECT `skill_id` FROM `tb_employee_skill` WHERE emp_id = '$emp_id'";
//    $result_edit = $conn->query($sql_edit);
//
//    if ($result_edit->num_rows > 0) {
//        while ($rowsk = $result_edit->fetch_assoc()) {
//            array_push($skill, $rowsk['skill_id']);
//        }
//    }
//}
?>
<?php
//Check Page Request Method post and update status 
//if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "update")) {
//    //Define variables
//    $emp_id = $f_nm = $l_nm = $address = $tp_no = $email = $nic = $gender = $cvl_stat = $reg_date = $desig = $regi_persn = $skill = null;
//    // print_r($_POST);
//    // for get multiple skill
//    $skill = array();
//    //define arry for display error messages
//    $e = array();
//    //Assign Data--------------------------------------
//    $emp_id = $_POST['emp_id'];
//    $f_nm = ucfirst(clean_input($_POST['f_nm']));
//    $l_nm = ucfirst(clean_input($_POST['l_nm']));
//    $address = clean_input($_POST['address']);
//    $tp_no = clean_input($_POST['tp_no']);
//    $email = clean_input($_POST['email']);
//    $nic = clean_input($_POST['nic']);
//    if (isset($_POST['gender'])) {
//        $gender = $_POST['gender'];
//    }
//    $pro_pic = $_POST['prv_profile_image'];
//    if (!empty($_FILES['profile_image']["name"])) {
//        $pro_pic = $_FILES['profile_image']["name"];
//    }
//    $cv = $_POST['prv_cv'];
//    if (!empty($_FILES['cv']["name"])) {
//        $cv = $_FILES['cv']["name"];
//    }
//    $cvl_stat = $_POST['cvl_stat'];
//    $reg_date = date("Y-m-d");
//    $desig = $_POST['designation'];
//    $status = "A";
//    $regi_persn = $_SESSION['user_id'];
//    if (isset($_POST['skill'])) {
//        $skill = $_POST['skill'];
//    }
//    //End assign data----------------------------------
//    //Check input fields are empty---------------------
//    if (empty($f_nm)) {
//        $e['f_nm'] = "The First Name should not be empty....!";
//    }
//    if (empty($l_nm)) {
//        $e['l_nm'] = "The Last Name should not be empty....!";
//    }
//    if (empty($address)) {
//        $e['address'] = "The address should not be empty....!";
//    }
//    if (empty($tp_no)) {
//        $e['tp_no'] = "The telephone number should not be empty....!";
//    }
//    if (empty($email)) {
//        $e['email'] = "The email address should not be empty....!";
//    }
//    if (empty($nic)) {
//        $e['nic'] = "The NIC should not be empty....!";
//    }
//    if (empty($gender)) {
//        $e['gender'] = "The gender should not be empty....!";
//    }
//    if (empty($cvl_stat)) {
//        $e['cvl_stat'] = "The civil status should not be empty....!";
//    }
//    if (empty($desig)) {
//        $e['desig'] = "The designation should not be empty....!";
//    }
//    echo $pro_pic;
//    if (empty($pro_pic)) {
//        $e['profile_image'] = "The profile image should not be empty....!";
//    }
//    if (empty($skill)) {
//        $e['skill'] = "The skill should not be empty....!";
//    }
//    echo $cv;
//    if (empty($cv)) {
//        $e['cv'] = "The cv should not be empty....!";
//    }
//    //End check input fields are empty-----------------
//    //Advance validation-------------------------------
//    if (!empty($f_nm)) {
//        if (!preg_match("/^[a-zA-Z]*$/", $f_nm)) {
//            $e['f_nm'] = "The First Name is invalid...!";
//        }
//    }
//    if (!empty($l_nm)) {
//        if (!preg_match("/^[a-zA-Z]*$/", $l_nm)) {
//            $e['l_nm'] = "The Last Name is invalid...!";
//        }
//    }
//    if (!empty($nic)) {
////        if (!preg_match("/^[a-zA-Z ]*$/", $l_nm)) {
////            $e['l_nm'] = "The Last Name is invalid...!";
////        }
//    }
//
//
//    if (!empty($tp_no)) {
//        if (!preg_match("/^[0-9+]*$/", $tp_no)) {
//            $x['tp_no'] = "<div class='alert alert-danger'>The tlephone number is invalid...!</div>";
//            $e = 0;
//        }
//    }
//
//
//    if (!empty($email)) {
//        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//            $e['email'] = "The Email address is invalid...!";
//        }
//    }
//
//    //End advance validation---------------------------
//    //profile image, upload and validation--------------------
//    if (empty($e) && !empty($_FILES['profile_image']["name"])) {
//        $target_dir = "../images/emp/";
//        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
//        $uploadOk = 1;
//        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
//        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
//        if ($check !== false) {
//            $uploadOk = 1;
//        } else {
//            $e['profile_image'] = "File is not an image.";
//            $uploadOk = 0;
//        }
//
//        if (file_exists($target_file)) {
//            $e['profile_image'] = "Sorry, file already exists.";
//            $uploadOk = 0;
//        }
//
//        if ($_FILES["profile_image"]["size"] > 500000) {
//            $e['profile_image'] = "Sorry, your file is too large.";
//            $uploadOk = 0;
//        }
//        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
//            $e['profile_image'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//            $uploadOk = 0;
//        }
//        if ($uploadOk == 1) {
//            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
//                $pro_pic = basename($_FILES["profile_image"]["name"]);
//                if ($_POST['prv_profile_image'] != null) {
//                    unlink("../images/emp/" . $_POST['prv_profile_image']);
//                }
//            } else {
//                $e['profile_image'] = "Sorry, there was an error uploading your file.";
//            }
//        }
//    }
//
//    //cv upload...
//    if (empty($e) && !empty($_FILES['cv']["name"])) {
//        $target_dir = "../cv/";
//        $target_file = $target_dir . basename($_FILES["cv"]["name"]);
//        $uploadOk = 1;
//        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
//
//        if (file_exists($target_file)) {
//            $e['cv'] = "Sorry, file already exists.";
//            $uploadOk = 0;
//        }
//
//        if ($_FILES["product_image"]["size"] > 500000) {
//            $e['cv'] = "Sorry, your file is too large.";
//            $uploadOk = 0;
//        }
//        if ($fileType != "pdf" && $fileType != "docx" && $fileType != "zip") {
//            $e['cv'] = "Sorry, only PDF, docx & zip files are allowed.";
//            $uploadOk = 0;
//        }
//        if ($uploadOk == 1) {
//            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file)) {
//                $cv = basename($_FILES["cv"]["name"]);
//                if ($_POST['prv_cv'] != null) {
//                    unlink("../cv/" . $_POST['prv_cv']);
//                }
//            } else {
//                $e['cv'] = "Sorry, there was an error uploading your file.";
//            }
//        }
//    }
//
//
//    //database connectivity------------------------------
//    if (empty($e)) {
//
//        echo $sql = "UPDATE `tb_employee` SET 
//                 `first_name`='$f_nm',
//                 `last_name`='$l_nm',
//                 `address`='$address',
//                 `tp_no`='$tp_no',
//                 `email`='$email',
//                 `nic`='$nic',
//                 `gender`='$gender',
//                 `civil_status`='$cvl_stat',
//                 `desig`='$desig',
//                 `pro_pic`='$pro_pic',
//                 `cv`='$cv',
//                 `reg_date`='$reg_date',
//                 `reg_person`='$regi_persn',
//                 `status`='' WHERE `employee_id`= '$emp_id'";
//
//        if ($conn->query($sql) === true) {
//            $f_nm = $l_nm = $address = $tp_no = $email = $nic = $pro_pic = $gender = $cvl_stat = $reg_date = $desig = $regi_persn = null;
//            if (!empty($skill)) {
//                $sql = "DELETE FROM `tb_employee_skill` WHERE `emp_id` = $emp_id";
//                $conn->query($sql);
//                foreach ($skill as $value) {
//                    $sql = "INSERT INTO `tb_employee_skill`(`emp_id`, `skill_id`) VALUES ('$emp_id','$value')";
//                    $conn->query($sql);
//                }
//
//                $skill = $emp_id = null;
//            }
//            
?>
<!--            <div class="alert alert-success alert-dismissible fade_show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! data updated</strong>
            </div>-->
<?php
//            // header("Refresh:3");
//        } else {
//            echo "Error" . $conn->error;
//        }
//    }
//    //end data send to database------------------------------
//}
?>

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"> <i class="fas fa-user-plus"></i> Payment Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" >
            <div class="card-body">
                <div class="row">

                    <div class="col">
                        <div class="form-group">
<?php
$sql = "SELECT * FROM tb_order WHERE order_status != 'DONE'";
$result = $conn->query($sql);
?>
                            <label for="cvl_stat">Order Id :</label>
                            <select class="form-control" id="order_id" name="order_id" onchange="loadPaytype(this.value);">
                                <option value="">--Select a Order--</option>
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
                                        <option value="<?php echo $row['order_id']; ?>"<?php
        if (@$order_id == $row['order_id']) {
            if ($row['order_id'] != null) {
                $pay_type = $row['order_status'];
            }
            ?> selected<?php } ?> > <?php echo $row['order_id']; ?> </option>
        <?php
    }
}
?>
                            </select>
                        </div>
                        <div class="text-danger"><?php echo @$e['order_id']; ?></div>
                    </div>
                </div>
                <div id="result_pay_type">

                    <!-- card-header view -->
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h5>Order Details</h5>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-hover table-responsive-md table-striped table-bordered">
                            <tbody>                     
                                <tr>
                                    <td>Product </td>
                                    <td></td>                                
                                </tr>
                                <tr>
                                    <td>Customer Name </td>
                                    <td></td>                                
                                </tr>
                                <tr>
                                    <td>Telephone No </td>
                                    <td></td>                                
                                </tr>
                                <tr>
                                    <td>Email address </td>
                                    <td></td>                                
                                </tr>
                                <tr>
                                    <td>NIC NO </td>
                                    <td> </td>                                
                                </tr>
                                <tr>
                                    <td>Amount </td>
                                    <td> <div class="text-danger"><?php echo @$e['amount']; ?></div></td>                                
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">

<?php if (@$_POST['operate'] != "edit") { ?>
                    <button type="submit" name="operate" value="insert" class="btn btn-primary">Pay</button>
                                    <?php
                                }
                                ?>
                                <?php if (@$_POST['operate'] == "edit") { ?>
                    <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                    <button type="submit" type="hidden" name="operate" id="update_btn" value="update"  class="btn btn-primary">Update</button>
                                    <?php
                                }
                                ?>
                <button type="submit" name="operate" value="cancel" class="btn btn-danger">Cancel</button>                                            
            </div>
        </form>
    </div>
    <!--/.card card-primary-->
</div>


<?php include '../footer.php'; ?>
<script type="text/javascript">
    function loadPaytype(order_id) {
        var mydata = "order_id=" + order_id + "&";
//   alert(mydata);
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "pay_type_box.php",
            success: function (data) {
                $("#result_pay_type").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
</script>