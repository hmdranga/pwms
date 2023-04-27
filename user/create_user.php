<!--
Page Name: create_user.php
Date Created: 2020-08-25
Date last modified: 2020-10-21
-->
<?php ob_start(); ?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//Check Page Request Method 
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "insert")) {
    //Define variables
    $first_name = $last_name = $user_name = $password = $confirm_password = $profile_image = $target_dir = $imageFileType = $check = null;

    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------

    $first_name = ucfirst(clean_input($_POST['first_name']));
    $last_name = ucfirst(clean_input($_POST['last_name']));
    $user_name = clean_input($_POST['user_name']);
    $password = password_input($_POST['password']);
    $confirm_password = password_input($_POST['confirm_password']);
    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($first_name)) {
        $e['first_name'] = "The First Name should not be empty....!";
    }
    if (empty($last_name)) {
        $e['last_name'] = "The Last Name should not be empty....!";
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
    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($first_name)) {
        if (!preg_match("/^[a-zA-Z]*$/", $first_name)) {
            $e['first_name'] = "The first name is invalid...!";
        }
    }
    if (!empty($last_name)) {
        if (!preg_match("/^[a-zA-Z]*$/", $last_name)) {
            $e['last_name'] = "The last name is invalid...!";
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
    //image upload and advance validation

    if (empty($e) && !empty($_FILES["profile_image"]["name"])) {
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
                $profile_image = basename($_FILES["profile_image"]["name"]);
            } else {
                $e['profile_image'] = "Sorry, there was an error uploading your file.";
            }
        }
    }
    //End advance validation---------------------------
    //data send to database------------------------------
    if (empty($e)) {

        $sql = "INSERT INTO `tb_user`(`user_name`, `password`, `first_name`, `last_name`, `profile_image`) VALUES ('$user_name','" . sha1($password) . "','$first_name','$last_name','$profile_image')";

        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade_show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! data inserted</strong>
            </div>
            <?php
            echo "Data Inserted";

            header("Refresh:3");
        } else {
            echo "Error" . $conn->error;
        }
    }
    //end data send to database------------------------------
}


//Check Page Request Method and data edit 
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "edit") {
    //Define variables
    $user_id = $first_name = $last_name = $user_name = $password = $confirm_password = $profile_image = $target_dir = $imageFileType = $check = null;
    $user_id = $_POST['user_id'];
    $sql_edit = "SELECT
     tb_user.user_id,
     tb_user.user_name,
     tb_user.password,
     tb_user.first_name,
     tb_user.last_name,
     tb_user.profile_image
     FROM tb_user 
     WHERE user_id='$user_id'";
    $result_edit = $conn->query($sql_edit);
    if ($result_edit->num_rows > 0) {
        while ($row = $result_edit->fetch_assoc()) {
            $user_id = $row['user_id'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $user_name = $row['user_name'];
            $passwordget = $row['password'];
//            $confirm_password = $row['password'];
            $profile_image = $row['profile_image'];
        }
    }
}

//Check Page Request Method post and update status 
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "update")) {
    //Define variables
    $user_id = $first_name = $last_name = $user_name = $password = $confirm_password = $profile_image = $target_dir = $imageFileType = $check = null;

    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------
    $user_id = $_POST['user_id'];
    $first_name = ucfirst(clean_input($_POST['first_name']));
    $last_name = ucfirst(clean_input($_POST['last_name']));
    $user_name = clean_input($_POST['user_name']);

    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($first_name)) {
        $e['first_name'] = "The First Name should not be empty....!";
    }
    if (empty($last_name)) {
        $e['last_name'] = "The Last Name should not be empty....!";
    }
    if (empty($user_name)) {
        $e['user_name'] = "The User Name should not be empty....!";
    }
    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($first_name)) {
        if (!preg_match("/^[a-zA-Z]*$/", $first_name)) {
            $e['first_name'] = "The first name is invalid...!";
        }
    }
    if (!empty($last_name)) {
        if (!preg_match("/^[a-zA-Z]*$/", $last_name)) {
            $e['last_name'] = "The last name is invalid...!";
        }
    }
    if (!empty($user_name)) {
        if (!preg_match("/^[a-zA-Z0-9@.]*$/", $user_name)) {
            $e['user_name'] = "The Username is invalid...!";
        }
    }

    //image upload and advance validation
    $profile_image = $_FILES['profile_image']["name"];
    if (empty($e) && isset($profile_image)) {
        echo $_POST['prv_profile_image'];
        if ($_POST['prv_profile_image'] != null) {
            unlink("../images/" . $_POST['prv_profile_image']);
        }
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
                $profile_image = basename($_FILES["profile_image"]["name"]);
            } else {
                $e['profile_image'] = "Sorry, there was an error uploading your file.";
            }
        }
    }
    //End advance validation---------------------------
    //database connectivity------------------------------
    if (empty($e)) {
        //,`profile_image`='$profile_image'

        $sql = "UPDATE `tb_user` SET `user_name`='$user_name',`first_name`='$first_name',`last_name`='$last_name',`profile_image`='$profile_image'  WHERE user_id = '$user_id'";

        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade_show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! data updated</strong>
            </div>
            <?php
            header("Refresh:3");
        } else {
            echo "Error" . $conn->error;
        }
    }
    //end data send to database------------------------------
}
?>
<div class="container-fluid">
    <div class="row">

        <div class="col-lg">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">User Creation Form</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form  role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="first_name">First Name :</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" value="<?php echo @$first_name; ?>">
                            <div class="text-danger"><?php echo @$e['first_name']; ?></div>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name :</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" value="<?php echo @$last_name; ?>">
                            <div class="text-danger"><?php echo @$e['last_name']; ?></div>
                        </div>
                        <div class="form-group">
                            <label for="address">User Name :</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter user name" value="<?php echo @$user_name; ?>">
                            <div class="text-danger"><?php echo @$e['user_name']; ?></div>
                        </div>
                        <p>Note : Password should be at least 8 characters & should include at least one uppercase letter, One number, and One special character.</p>
                        <div class="form-group">
                            <label for="password">Password :</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" value="<?php echo @$password; ?>">

                            <div class="text-danger"><?php echo @$e['password']; ?></div>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password"> Confirm Password :</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-Enter password" value="<?php echo @$confirm_password; ?>">

                            <div class="text-danger"><?php echo @$e['confirm_password']; ?></div>
                        </div>

                        <div class="form-group">
                            <label for="profile_image">Profile picture :</label>
                            <div class="input-group custom-file">
                                <input type="file" name="profile_image" id="profile_image" class="custom-file-input">
                                <label class="custom-file-label" for="chose profile pic">Choose file</label>
                            </div>

                            <div class="text-danger"><?php echo @$e['profile_image']; ?></div>
                            <input type="hidden"  name="prv_profile_image" value="<?php echo $profile_image; ?>" >
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <?php if (@$_POST['operate'] != "edit") { ?>
                            <button type="submit" name="operate" value ="insert" class="btn btn-primary">Create</button>
                            <?php
                        }
                        ?>
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <?php if (@$_POST['operate'] == "edit") { ?>
                            <button type="submit" type="hidden" name="operate" id="update_btn" value="update"  class="btn btn-primary">Update</button>
                            <?php
                        }
                        ?>
                        <button type="submit" name="operate" value="cancel" class="btn btn-info">Cancel</button> 
                    </div>
                </form>
                <!-- form end -->
            </div>
        </div>
        <?php
//sql for list table
        $sql_view = "SELECT `user_id`, `first_name`, `last_name`, `profile_image` FROM `tb_user`";
        $result_view = $conn->query($sql_view);

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
                if ($search_type == "user_id") {
                    if (!preg_match("/^[0-9]*$/", $search)) {
                        $e['search'] = "The user id is invalid...!";
                    }
                }
                if ($search_type == "user_name") {
                    if (!preg_match("/^[a-zA-Z0-9@.]*$/", $search)) {
                        $e['search'] = "enterd user name is invalid...!";
                    }
                }
                if ($search_type == "first_name") {

                    if (!preg_match("/^[a-zA-Z]*$/", $search)) {
                        $e['search'] = "enterd first name is invalid...!";
                    }
                }
                if ($search_type == "last_name") {
                    if (!preg_match("/^[a-zA-Z]*$/", $search)) {
                        $e['search'] = "enterd last name is invalid...!";
                    }
                }
                //not exist validation
                if (empty($e['search'])) {
                    $sql = "SELECT `$search_type` FROM `tb_user` WHERE `$search_type` LIKE '%$search%'";
                    $result = $conn->query($sql);
                    if ($result->num_rows == 0) {
                        $e['search'] = "enterd data is not exist..";
                    }
                }
            }
            if (empty($e)) {
                $sql_view = "SELECT `user_id`, `first_name`, `last_name`, `profile_image` FROM `tb_user` WHERE `$search_type` LIKE '%$search%'";
                $result_view = $conn->query($sql_view);
            }
        }
        ?>
        <div class="col-lg">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="col">
                        <h3 class="card-title">Search</h3>
                    </div>
                </div>
                <div class="card-body  ">
                    <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="search_type">Search Type :</label>
                            <select class="form-control select2"  name="search_type" id="search_type">
                                <option value="">select parameter</option>
                                <option value="user_id">User ID</option>
                                <option value="user_name">User Name</option>
                                <option value="first_name">First Name</option>
                                <option value="last_name">Last Name</option>
                            </select>
                            <div class="text-danger"><?php echo @$e['search_type']; ?></div>
                        </div>
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
                    </form>
                </div>
                <!--card header 2nd-->
                <div class="card-header">

                    <div class="row">
                        <div class="col">
                            <h3 class="card-title">View User</h3>
                        </div>
                        <div class="col">
                            <?php
                            echo"Total records: " . $result_view->num_rows;
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
                                    <th>User Id</th>
                                    <th>Name</th>
                                    <th>Profile Image</th>
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
                                            <td><?php echo $row['user_id']; ?></td>
                                            <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                            <td><?php
                                                // if profile image null then assign defalt 
                                                if ($row['profile_image'] == NULL) {
                                                    ?>
                                                    <img src="<?php echo ROOT; ?>images/no_image.png" alt="empty image" class=" img-size-50 img-thumbnail" style="opacity: .9">
                                                <?php } else { ?>
                                                    <img src="<?php echo ROOT; ?>images/<?php echo $row['profile_image']; ?>" alt="profile image" class=" img-size-50 img-thumbnail"
                                                         style="opacity: .9">
                                                         <?php
                                                     }
                                                     ?>
                                            </td>
                                            <td>
                                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                                    <button type="submit" name="operate" value="edit" class="btn btn-default" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-edit"></i></button>                   
                                                </form>
                                            </td>
                                            <td >
                                                <form method="post" action="delete_user.php">
                                                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                                    <input type="hidden" name="profile_image" value="<?php echo $row['profile_image']; ?>">
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
        </div>
        <!--./col-lg-->
    </div>
    <!--./row-->
</div>
<?php include '../footer.php'; ?>
<?php ob_end_flush(); ?>