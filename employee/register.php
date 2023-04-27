<!--
Page Name: register.php(employee)
Date Created :28/06/2020
-->
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//print_r($_POST);
//Check Page Request Method 
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "insert")) {
    //Define variables
    $emp_id = $f_nm = $l_nm = $address = $tp_no = $email = $nic = $pro_pic = $gender = $cvl_stat = $reg_date = $desig = $regi_persn = $skill = $user_name = $password = $confirm_password = null;
    //print_r($_POST);
    $skill = array();
    //define arry for display error messages
    $e = array();
    //Assign Data---------------------------------------------------------------
    $user_name = clean_input($_POST['user_name']);
    $password = password_input($_POST['password']);
    $confirm_password = password_input($_POST['confirm_password']);
    $f_nm = ucfirst(clean_input($_POST['f_nm']));
    $l_nm = ucfirst(clean_input($_POST['l_nm']));
    $address = clean_input($_POST['address']);
    $tp_no = clean_input($_POST['tp_no']);
    $email = clean_input($_POST['email']);
    $nic = clean_input($_POST['nic']);
    $pro_pic = $_FILES['profile_image']["name"];
    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];
    }
    $cv = $_FILES['cv']["name"];
    $cvl_stat = $_POST['cvl_stat'];
    $reg_date = date("Y-m-d");
    $desig = $_POST['designation'];
    $status = "A"; // active or inactive
    $regi_persn = $_SESSION['user_id'];
    if (isset($_POST['skill'])) {
        $skill = $_POST['skill'];
    }
    //End assign data-----------------------------------------------------------
    //Check input fields are empty----------------------------------------------
    if (empty($f_nm)) {
        $e['f_nm'] = "The First Name should not be empty....!";
    }
    if (empty($l_nm)) {
        $e['l_nm'] = "The Last Name should not be empty....!";
    }
    if (empty($address)) {
        $e['address'] = "The address should not be empty....!";
    }
    if (empty($tp_no)) {
        $e['tp_no'] = "The telephone number should not be empty....!";
    }
    if (empty($email)) {
        $e['email'] = "The email address should not be empty....!";
    }

    if (empty($nic)) {
        $e['nic'] = "The NIC should not be empty....!";
    }

    if (empty($gender)) {
        $e['gender'] = "The gender should not be empty....!";
    }
    if (empty($cvl_stat)) {
        $e['cvl_stat'] = "The civil status should not be empty....!";
    }
    if (empty($desig)) {
        $e['desig'] = "The designation should not be empty....!";
    }
    if (empty($pro_pic)) {
        $e['profile_image'] = "The profile image should not be empty....!";
    }

    if (empty($skill)) {
        $e['skill'] = "The skill should not be empty....!";
    }
    if (empty($cv)) {
        $e['cv'] = "The cv should not be empty....!";
    }
    if (empty($user_name)) {
        $e['user_name'] = "The User Name should not be empty....!";
    }
    if (empty($password) && $_POST['operate'] == "insert") {
        $e['password'] = "The password should not be empty....!";
    }
    if (empty($confirm_password) && $_POST['operate'] == "insert") {
        $e['confirm_password'] = "The confirm password should not be empty....!";
    }

    //End check input fields are empty------------------------------------------
    //Advance validation--------------------------------------------------------
    if (!empty($f_nm)) {
        if (!preg_match("/^[a-zA-Z]*$/", $f_nm)) {
            $e['f_nm'] = "The First Name is invalid...!";
        }
    }
    if (!empty($l_nm)) {
        if (!preg_match("/^[a-zA-Z]*$/", $l_nm)) {
            $e['l_nm'] = "The Last Name is invalid...!";
        }
    }
    if (!empty($nic)) {
//        if (!preg_match("/^[a-zA-Z ]*$/", $l_nm)) {
//            $e['l_nm'] = "The Last Name is invalid...!";
//        }
        $sql = "SELECT `nic` FROM `tb_employee` WHERE nic= '$nic'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $e['nic'] = "NIC number is already exist..!";
        }
    }


    if (!empty($tp_no)) {
        if (!preg_match("/^[0-9+]*$/", $tp_no)) {
            $e['tp_no'] = "<div class='alert alert-danger'>The tlephone number is invalid...!</div>";
            
        }
        
        // telephone number already exsist validation
        $sql = "SELECT `tp_no` FROM `tb_employee` WHERE tp_no= '$tp_no'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $e['tp_no'] = "Telephone number is already exist..!";
        }
    }

    if (!empty($user_name)) {
        if (!preg_match("/^[a-zA-Z0-9@.]*$/", $user_name)) {
            $e['user_name'] = "The Username is invalid...!";
        }
        // user name already exsist validation

        $sql_username = "SELECT `user_name` FROM `tb_user` WHERE `user_name`= '$user_name'";
        $result = $conn->query($sql_username);
        if ($result->num_rows > 0) {
            $e['user_name'] = "user name is already exist..!";
        }
    }

    if (!empty($confirm_password and $password)) {
        //password confermation 
        if ($password != $confirm_password) {
            $e['confirm_password'] = "password do not match..!";
        }
        //8 characters should have in password.
        if (strlen($password) < 8) {
            $e['password'] = "password should minimum 8 characters..!";
        }
        if (!preg_match('@[A-Z]@', $password)) {
            $e['password'] = "password should include at least one uppercase letter..!";
        }
        if (!preg_match('@[a-z]@', $password)) {
            $e['password'] = "password should include at least one lowercase letter..!";
        }
        if (!preg_match('@[0-9]@', $password)) {
            $e['password'] = "password should include at least one number..!";
        }
        if (!preg_match('@[^\w]@', $password)) {
            $e['password'] = "password should include at least one special character..!";
        }

        //validate letters numbers sysmbles are excist
    }


    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $e['email'] = "The Email address is invalid...!";
        }
    }

    //End advance validation---------------------------
    //
    //profile image, upload and validation--------------------
    if (empty($e)) {
        $target_dir = "../images/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $e['profile_image'] = "File is not an image.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            $e['profile_image'] = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES["profile_image"]["size"] > 500000) {
            $e['profile_image'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $e['profile_image'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                $pro_pic = basename($_FILES["profile_image"]["name"]);
            } else {
                $e['profile_image'] = "Sorry, there was an error uploading your file.";
            }
        }
    }

    //cv upload...
    if (empty($e)) {
        $target_dir = "../cv/";
        $target_file = $target_dir . basename($_FILES["cv"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (file_exists($target_file)) {
            $e['cv'] = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES["cv"]["size"] > 500000) {
            $e['cv'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($fileType != "pdf" && $fileType != "docx" && $fileType != "zip") {
            $e['cv'] = "Sorry, only PDF, docx & zip files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file)) {
                $cv = basename($_FILES["cv"]["name"]);
            } else {
                $e['cv'] = "Sorry, there was an error uploading your file.";
            }
        }
    }
    //data send to database----------------------------

    if (empty($e)) {

        $sql = "INSERT INTO `tb_user`(`user_name`, `password`, `first_name`, `last_name`, `profile_image`)
                VALUES ('$user_name','" . sha1($password) . "','$f_nm','$l_nm','$pro_pic')";
        if ($conn->query($sql) === true) {
            $user_id = $conn->insert_id;

            if ($desig == 6) {// manager
                $module = array("01", "0101", "0102", "02", "0201", "0202", "10", "1001", "1002", "1003", "03", "0301", "0302", "04", "0401", "05", "0501", "06", "0601", "07", "0701", "0702", "09", "0901", "11", "1101", "12");
                foreach ($module as $modval) {

                    $sql_mod = "INSERT INTO `tb_user_module`( `user_id`, `module_id`) VALUES ('$user_id','$modval')";
                    if ($conn->query($sql_mod) == true) {
                        
                    } else {
                        echo "Error " . $conn->error;
                    }
                }
            } elseif ($desig == 5) { //cashier
                $module = array("01", "0101", "02", "0201", "05", "0501", "06", "0601", "09", "0901");
                foreach ($module as $modval) {

                    $sql_mod = "INSERT INTO `tb_user_module`( `user_id`, `module_id`) VALUES ('$user_id','$modval')";
                    if ($conn->query($sql_mod) == true) {
                        
                    } else {
                        echo "Error " . $conn->error;
                    }
                }
            } elseif ($desig == 1 || $desig == 2) {//designer/typist
                $module = array("01", "0101", "02", "0201", "03", "0301", "05", "0501");

                foreach ($module as $modval) {

                    $sql_mod = "INSERT INTO `tb_user_module`( `user_id`, `module_id`) VALUES ('$user_id','$modval')";
                    if ($conn->query($sql_mod) == true) {
                        
                    } else {
                        echo "Error " . $conn->error;
                    }
                }
            } elseif ($desig == 3 || $desig == 4) {//press operator/press assistant
                $module = array("01", "0101", "02", "0201", "03", "0301", "04", "0401", "05", "0501");
                foreach ($module as $modval) {

                    $sql_mod = "INSERT INTO `tb_user_module`( `user_id`, `module_id`) VALUES ('$user_id','$modval')";
                    if ($conn->query($sql_mod) == true) {
                        
                    } else {
                        echo "Error " . $conn->error;
                    }
                }
            }

            $sql = "INSERT INTO `tb_employee`
            (`first_name`, `last_name`, `address`, `tp_no`, `email`, `nic`, `pro_pic`, `cv`, `gender`, `civil_status`, `desig`, `reg_date`, `reg_person`,`user_id` , `status`) 
             VALUES ('$f_nm','$l_nm','$address','$tp_no','$email','$nic','$pro_pic','$cv','$gender','$cvl_stat', '$desig', '$reg_date', '$regi_persn','$user_id','$status')";
            if ($conn->query($sql) === true) {
                ?>
                <div class="alert alert-success alert-dismissible fade_show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success! Employee registered..</strong>
                </div>
                <?php
                $emp_id = $conn->insert_id;

                foreach ($skill as $value) {
                    $sqlskl = "INSERT INTO `tb_employee_skill`( `emp_id`, `skill_id`)  VALUES ('$emp_id','$value')";
                    if ($conn->query($sqlskl) == true) {
                        ?>
                        <div class="alert alert-success alert-dismissible fade_show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success! skill assigned..</strong>
                        </div>
                        <?php
                    } else {
                        echo "Error " . $conn->error;
                    }
                }

                $user_id = $emp_id = $f_nm = $l_nm = $address = $tp_no = $email = $nic = $pro_pic = $gender = $cvl_stat = $reg_date = $desig = $regi_persn = $skill = null;
            } else {
                echo "Error" . $conn->error;
            }
        } else {
            echo "Error" . $conn->error;
        }
    }
//    end data send to database------------------------------
}
?>
<?php
//Check Page Request Method and data edit 
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "edit") {
    //Define variables
    $emp_id = $f_nm = $l_nm = $address = $tp_no = $email = $nic = $pro_pic = $gender = $cvl_stat = $reg_date = $desig = $regi_persn = $skill = $cv = null;

    $skill = array();
    $emp_id = $_POST['emp_id'];
    $sql_edit = "SELECT * FROM `tb_employee` WHERE `employee_id`='$emp_id'";
    $result_edit = $conn->query($sql_edit);
    if ($result_edit->num_rows > 0) {
        while ($row = $result_edit->fetch_assoc()) {
            $f_nm = $row['first_name'];
            $l_nm = $row['last_name'];
            $address = $row['address'];
            $tp_no = $row['tp_no'];
            $email = $row['email'];
            $nic = $row['nic'];
            $pro_pic = $row['pro_pic'];
            $cv = $row['cv'];
            $gender = $row['gender'];
            $cvl_stat = $row['civil_status'];
            $desig = $row['desig'];
        }
    }
    $sql_edit = "SELECT `skill_id` FROM `tb_employee_skill` WHERE emp_id = '$emp_id'";
    $result_edit = $conn->query($sql_edit);

    if ($result_edit->num_rows > 0) {
        while ($rowsk = $result_edit->fetch_assoc()) {
            array_push($skill, $rowsk['skill_id']);
        }
    }
}
?>
<?php
//Check Page Request Method post and update status 
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "update")) {
    //Define variables
    $emp_id = $f_nm = $l_nm = $address = $tp_no = $email = $nic = $gender = $cvl_stat = $reg_date = $desig = $regi_persn = $skill = null;
    // print_r($_POST);
    // for get multiple skill
    $skill = array();
    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------
    $emp_id = $_POST['emp_id'];
    $f_nm = ucfirst(clean_input($_POST['f_nm']));
    $l_nm = ucfirst(clean_input($_POST['l_nm']));
    $address = clean_input($_POST['address']);
    $tp_no = clean_input($_POST['tp_no']);
    $email = clean_input($_POST['email']);
    $nic = clean_input($_POST['nic']);
    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];
    }
    $pro_pic = $_POST['prv_profile_image'];
    if (!empty($_FILES['profile_image']["name"])) {
        $pro_pic = $_FILES['profile_image']["name"];
    }
    $cv = $_POST['prv_cv'];
    if (!empty($_FILES['cv']["name"])) {
        $cv = $_FILES['cv']["name"];
    }
    $cvl_stat = $_POST['cvl_stat'];
    $reg_date = date("Y-m-d");
    $desig = $_POST['designation'];
    $status = "A";
    $regi_persn = $_SESSION['user_id'];
    if (isset($_POST['skill'])) {
        $skill = $_POST['skill'];
    }
    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($f_nm)) {
        $e['f_nm'] = "The First Name should not be empty....!";
    }
    if (empty($l_nm)) {
        $e['l_nm'] = "The Last Name should not be empty....!";
    }
    if (empty($address)) {
        $e['address'] = "The address should not be empty....!";
    }
    if (empty($tp_no)) {
        $e['tp_no'] = "The telephone number should not be empty....!";
    }
    if (empty($email)) {
        $e['email'] = "The email address should not be empty....!";
    }
    if (empty($nic)) {
        $e['nic'] = "The NIC should not be empty....!";
    }
    if (empty($gender)) {
        $e['gender'] = "The gender should not be empty....!";
    }
    if (empty($cvl_stat)) {
        $e['cvl_stat'] = "The civil status should not be empty....!";
    }
    if (empty($desig)) {
        $e['desig'] = "The designation should not be empty....!";
    }
//    echo $pro_pic;
    if (empty($pro_pic)) {
        $e['profile_image'] = "The profile image should not be empty....!";
    }
    if (empty($skill)) {
        $e['skill'] = "The skill should not be empty....!";
    }
//    echo $cv;
    if (empty($cv)) {
        $e['cv'] = "The cv should not be empty....!";
    }
    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($f_nm)) {
        if (!preg_match("/^[a-zA-Z]*$/", $f_nm)) {
            $e['f_nm'] = "The First Name is invalid...!";
        }
    }
    if (!empty($l_nm)) {
        if (!preg_match("/^[a-zA-Z]*$/", $l_nm)) {
            $e['l_nm'] = "The Last Name is invalid...!";
        }
    }
    if (!empty($nic)) {
//        if (!preg_match("/^[a-zA-Z ]*$/", $l_nm)) {
//            $e['l_nm'] = "The Last Name is invalid...!";
//        }
    }


    if (!empty($tp_no)) {
        if (!preg_match("/^[0-9+]*$/", $tp_no)) {
            $x['tp_no'] = "<div class='alert alert-danger'>The tlephone number is invalid...!</div>";
            $e = 0;
        }
    }


    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $e['email'] = "The Email address is invalid...!";
        }
    }

    //End advance validation---------------------------
    //profile image, upload and validation--------------------
    if (empty($e) && !empty($_FILES['profile_image']["name"])) {
        $target_dir = "../images/emp/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $e['profile_image'] = "File is not an image.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            $e['profile_image'] = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES["profile_image"]["size"] > 500000) {
            $e['profile_image'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $e['profile_image'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                $pro_pic = basename($_FILES["profile_image"]["name"]);
                if ($_POST['prv_profile_image'] != null) {
                    unlink("../images/emp/" . $_POST['prv_profile_image']);
                }
            } else {
                $e['profile_image'] = "Sorry, there was an error uploading your file.";
            }
        }
    }

    //cv upload...
    if (empty($e) && !empty($_FILES['cv']["name"])) {
        $target_dir = "../cv/";
        $target_file = $target_dir . basename($_FILES["cv"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (file_exists($target_file)) {
            $e['cv'] = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES["product_image"]["size"] > 500000) {
            $e['cv'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($fileType != "pdf" && $fileType != "docx" && $fileType != "zip") {
            $e['cv'] = "Sorry, only PDF, docx & zip files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file)) {
                $cv = basename($_FILES["cv"]["name"]);
                if ($_POST['prv_cv'] != null) {
                    unlink("../cv/" . $_POST['prv_cv']);
                }
            } else {
                $e['cv'] = "Sorry, there was an error uploading your file.";
            }
        }
    }


    //database connectivity------------------------------
    if (empty($e)) {

        $sql = "UPDATE `tb_employee` SET 
                 `first_name`='$f_nm',
                 `last_name`='$l_nm',
                 `address`='$address',
                 `tp_no`='$tp_no',
                 `email`='$email',
                 `nic`='$nic',
                 `gender`='$gender',
                 `civil_status`='$cvl_stat',
                 `desig`='$desig',
                 `pro_pic`='$pro_pic',
                 `cv`='$cv',
                 `reg_date`='$reg_date',
                 `reg_person`='$regi_persn',
                 `status`='' WHERE `employee_id`= '$emp_id'";

        if ($conn->query($sql) === true) {
            $f_nm = $l_nm = $address = $tp_no = $email = $nic = $pro_pic = $gender = $cvl_stat = $reg_date = $desig = $regi_persn = null;
            if (!empty($skill)) {
                $sql = "DELETE FROM `tb_employee_skill` WHERE `emp_id` = $emp_id";
                $conn->query($sql);
                foreach ($skill as $value) {
                    $sql = "INSERT INTO `tb_employee_skill`(`emp_id`, `skill_id`) VALUES ('$emp_id','$value')";
                    $conn->query($sql);
                }

                $skill = $emp_id = null;
            }
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

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"> <i class="fas fa-user-plus"></i> Employee Registration Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" >
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="f_nm">First Name :</label>
                            <input type="text" class="form-control" id="f_nm" name="f_nm" placeholder="Enter first name" value="<?php echo @$f_nm; ?>">
                            <div class="text-danger"><?php echo @$e['f_nm']; ?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="last_name">Last Name :</label>
                            <input type="text" class="form-control" id="l_" name="l_nm" placeholder="Enter last name" value="<?php echo @$l_nm; ?>">
                            <div class="text-danger"><?php echo @$e['l_nm']; ?></div>
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

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="address">Address :</label>
                            <textarea class="form-control" id="address" name="address" placeholder="Enter address"><?php echo @$address; ?></textarea>
                            <div class="text-danger"><?php echo @$e['address']; ?></div>
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
                            <label for="address">User Name :</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter user name" value="<?php echo @$user_nm; ?>">
                            <div class="text-danger"><?php echo @$e['user_name']; ?></div>
                        </div>
                    </div>

                </div>


                <div class="row">

                    <div class="col">
                        <div class="form-group">
                            <label for="password">Password :</label>

                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" value="<?php echo @$password; ?>">

                            <div class="text-danger"><?php echo @$e['password']; ?></div>
                        </div>
                        <p>Note : Password should be at least 8 characters & should include at least one uppercase letter, One number, and One special character.</p>

                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="confirm_password"> Confirm Password :</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-Enter password" value="<?php echo @$confirm_password; ?>">

                            <div class="text-danger"><?php echo @$e['confirm_password']; ?></div>
                        </div>

                    </div>

                </div>



                <div class="row">
                    <div class="col"> 
                        <div class="form-group">
                            <label for="gender">Gender :</label>
                            <br>
<?php
$sql = "SELECT * FROM `tb_gender` ORDER BY `tb_gender`.`gender` DESC";
$result = $conn->query($sql);
?>
                            <div class="form-check form-check-inline">
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
                                        <input class="form-check-input" type="radio" name="gender" id="<?php echo $row['gender_id']; ?>" value="<?php echo $row['gender_id']; ?>" <?php if (@$gender == $row['gender_id']) { ?>checked <?php } ?>>
                                        <label class="form-check-label" for="<?php $row['gender_id']; ?>"> <?php echo $row['gender']; ?> </label>
                                        &nbsp;&nbsp;
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="text-danger"><?php echo @$e['gender']; ?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                                <?php
                                $sql = "SELECT * FROM `tb_civil_status";
                                $result = $conn->query($sql);
                                ?>
                            <label for="designation">Civil Status :</label>
                            <select class="form-control" id="cvl_stat" name="cvl_stat" >
                                <option value="">--Select a Status--</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $row['civil_status_id']; ?>"<?php if (@$cvl_stat == $row['civil_status_id']) { ?> selected<?php } ?> > <?php echo $row['civil_status']; ?> </option>
        <?php
    }
}
?>
                            </select>
                        </div>
                        <div class="text-danger"><?php echo @$e['cvl_stat']; ?></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="profile_image">Profile picture :</label>
                            <div class="input-group custom-file">
                                <input type="file" name="profile_image" id="profile_image" class="custom-file-input">
                                <label class="custom-file-label" for="chose profile pic">Choose image</label>
                            </div>
                            <div class="text-danger"><?php echo @$e['profile_image']; ?></div>
                            <input type="hidden"  name="prv_profile_image" value="<?php echo $pro_pic; ?>" >
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="cv">CV :</label>
                            <div class="input-group custom-file">
                                <input type="file" name="cv" id="cv" class="custom-file-input">
                                <label class="custom-file-label" for="chose cv file">Choose file</label>
                            </div>

                            <div class="text-danger"><?php echo @$e['cv']; ?></div>
                            <input type="hidden"  name="prv_cv" value="<?php echo $cv; ?>" >
                        </div>
                    </div>
                </div>

                <div class="row ">
                    <div class="col">
                        <div class="form-group">
<?php
$sql = "SELECT * FROM `tb_designation`";
$result = $conn->query($sql);
?>
                            <label for="designation">Designation :</label>
                            <select class="form-control" id="designation" name="designation" onchange="loadSkill(this.value);">
                                <option value="">--Select a Designation--</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $row['designation_id']; ?>"<?php if (@$desig == $row['designation_id']) { ?> selected<?php } ?> > <?php echo $row['designation']; ?> </option>
        <?php
    }
}
?>
                            </select>
                            <div class="text-danger"><?php echo @$e['desig']; ?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group" id="result_skill">
                            <label for="designation">Skill :</label>
                        </div>
                        <div class="text-danger"><?php echo @$e['skill']; ?></div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">

<?php if (@$_POST['operate'] != "edit") { ?>
                    <button type="submit" name="operate" value="insert" class="btn btn-primary">Register</button>
    <?php
}
?>
<?php if (@$_POST['operate'] == "edit") { ?>
                    <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                    <button type="submit" type="hidden" name="operate" id="update_btn" value="update"  class="btn btn-primary">Update</button>
                    <?php
                }
                ?>
                <button type="submit" name="operate" value="cancel" class="btn btn-info">Cancel</button>                                            
            </div>
        </form>
    </div>
</div>
                <?php
//sql for list table
                $sql_view = "SELECT * FROM `tb_employee`";


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
                        $sql_view = "SELECT * FROM `tb_employee` WHERE `$search_type` LIKE '%$search%'";
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
                                <option value="first_name">first name</option>
                                <option value="last_name">last name</option>
                                <option value="tp_no">telephone</option>
                                <option value="email">email</option>
                                <option value="address">address</option>
                                <option value="nic">NIC no</option>
                                <option value="gender">gender</option>
                                <option value="desig">designation</option>
                                <option value="status">civil status</option>
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
                <h3 class="card-title"><i class="fas fa-users"></i> View Employee</h3>
            </div>
            <div class="col">
<?php
echo"Employee count: " . $result_view->num_rows;
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
                        <th>Designation</th>
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
                                <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                <td><?php
        $sql = "SELECT  `designation` FROM `tb_designation` WHERE `designation_id`=" . $row['desig'];
        $result = $conn->query($sql)->fetch_assoc();
        echo $result['designation'];
        ?></td>
                                <td><?php echo $row['tp_no']; ?></td>
                                <td >
                                    <form method="post" action="emp_view.php">
                                        <input type="hidden" name="emp_id" value="<?php echo $row['employee_id']; ?>">
                                        <button type="submit" name="operate" value="view" class="btn btn-default" onmouseover="this.style.color = '#cad315'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-eye"></i></button>         
                                    </form>
                                </td>
                                <td>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <input type="hidden" name="emp_id" value="<?php echo $row['employee_id']; ?>">
                                        <button type="submit" name="operate" value="edit" class="btn btn-default" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-edit"></i></button>                   
                                    </form>
                                </td>
                                <td >
                                    <form method="post" action="emp_dlt.php">
                                        <input type="hidden" name="emp_id" value="<?php echo $row['employee_id']; ?>">
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

    function loadSkill(desig_id) {
        var mydata = "desig_id=" + desig_id + "&";
//   alert(mydata);
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "skill_box.php",
            success: function (data) {
                $("#result_skill").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
</script>