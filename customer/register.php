<!--
Page Name: register.php(customer)
Date Created :28/06/2020
-->
<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//Check Page Request Method
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["operate"] == "register") {
    // print_r($_POST);
    //Define variables
    $first_name = $last_name = $address = $tp_no = $email = $gender = $nic = null;
    $e = array();
    //Assign Data--------------------------------------
    $first_name = clean_input($_POST['first_name']);
    $last_name = clean_input($_POST['last_name']);
    $address = clean_input($_POST['address']);
    $tp_no = clean_input($_POST['tp_no']);
    $email = clean_input($_POST['email']);
    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];
    }
    $nic = clean_input($_POST['nic']);
    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($first_name)) {
        $e['first_name'] = "The First Name should not be empty....!";
    }
    if (empty($last_name)) {
        $e['last_name'] = "The Last Name should not be empty....!";
    }
    if (empty($address)) {
        $e['address'] = "The Address should not be empty....!";
    }
    if (empty($tp_no)) {
        $e['tp_no'] = "The Telephone number should not be empty....!";
    }
    if (empty($email)) {
        $e['email'] = "The Email should not be empty....!";
    }
    if (empty($gender)) {
        $e['gender'] = "The Gender should not be empty....!";
    }
    if (empty($nic)) {
        $e['nic'] = "The National identity card should not be empty....!";
    }
    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($first_name)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $first_name)) {
            $e['first_name'] = "The first name is invalid...!";
        }
    }
    if (!empty($last_name)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $last_name)) {
            $e['last_name'] = "The last name is invalid...!";
        }
    }
    if (!empty($address)) {
//        if (!preg_match("/^[a-zA-Z0-9/:;,-. ]*$/", $address)) {
//            $e['address'] = "The adress is invalid...!";
//        }
    }
    if (!empty($tp_no)) {
        if (!preg_match("/^[0-9+]*$/", $tp_no)) {
            $e['tp_no'] = "The tlephone number is invalid...!";
        }
        if (strlen($tp_no) <> 9 && strlen($tp_no) <> 10 && strlen($tp_no) <> 11 && strlen($tp_no) <> 12 && strlen($tp_no) <> 13) {
            $e['nic'] = "The telephone number length is invalid..!";
        }
    }

    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $e['email'] = "The Email address is invalid...!";
        }
    }

    if (!empty($nic)) {

        if (strlen($nic) <> 10 && strlen($nic) <> 12) {
            $e['nic'] = "The NIC is invalid..";
        }
        if (strlen($nic) == 10) {
            if (strtoupper(substr($nic, -1)) <> "V" && strtoupper(substr($nic, -1)) <> "X") {
                $e['nic'] = "*The NIC is invalid..";
            }
            if (!is_numeric(substr($nic, 0, 9))) {
                $e['nic'] = "**The NIC is invalid.."; // may be wrong
            }
        }
        if (strlen($nic) == 12) {
            if (!is_numeric($nic)) {
                $e['nic'] = "***The NIC is invalid..";
            }
        }
    }

    //End advance validation---------------------------
    if (empty($e)) {
        $sql = "INSERT INTO `tb_customer`(`first_name`, `last_name`, `address`, `contact_no`, `email`, `gender`, `nic`) VALUES ('$first_name','$last_name','$address','$tp_no','$email','$gender','$nic')";

        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success!</strong>Data Inserted.
            </div>

            <?php
            header("Refresh:3");
        } else {

            echo "Error" . $conn->error;
        }
    }
}
?>
<div class="container-fluid">
    <div class="card card-primary">

        <div class="card-header">
            <h3 class="card-title">Customer Registration Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="first_name">First Name :</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" value="<?php echo @$first_name; ?>">
                            <div class="text-danger"><?php echo @$e['first_name']; ?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="last_name">Last Name :</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" value="<?php echo @$last_name; ?>">
                            <div class="text-danger"><?php echo @$e['last_name']; ?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                    <div class="form-group">
                        <label for="nic">NIC NO :</label>
                        <input type="text" class="form-control" id="nic" name="nic" placeholder="Enter nic no" value="<?php echo @$nic; ?>">
                        <div class="text-danger"><?php echo @$e['nic']; ?></div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="gender">Gender :</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="M" <?php if (@$gender == "M") { ?>checked <?php } ?>>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="F"<?php if (@$gender == "F") { ?>checked <?php } ?>>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                        <div class="text-danger"><?php echo @$e['gender']; ?></div>
                    </div>
                </div>
                
                </div>
                
                <div class="row">
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
                    <div class="col">
                        <div class="form-group">
                            <label for="email">Email address :</label>
                            <input type="text" name="email" id="email" class="form-control"  placeholder="Enter email" value="<?php echo @$email; ?>">
                            <div class="text-danger"><?php echo @$e['email']; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col">
                <div class="form-group">
                    <label for="address">Address :</label>
                    <textarea class="form-control" id="address" name="address" placeholder="Enter address"><?php echo @$address; ?></textarea>
                    <div class="text-danger"><?php echo @$e['address']; ?></div>
                </div>
                </div>
                
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" name="operate" value="register" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<?php include '../footer.php'; ?>
<?php
ob_end_flush();
?>