<!--
Page Name: register.php(product)
Date Created :09/10/2020
-->
<?php ob_start(); ?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//product creation
//Check Page Request Method and product register
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['operate'] == "product_insert") {
    //Define variables---------------------------------
    $product_name = $description = $product_image = $target_dir = $imageFileType = $check = null;
    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------
    $product_name = ucfirst(clean_input($_POST['product_name']));
    $description = clean_input($_POST['description']);
    $product_image = $_FILES['product_image']["name"];
    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($product_name)) {
        $e['product_name'] = "The product name should not be empty....!";
    }
    if (empty($description)) {
        $e['description'] = "The description should not be empty....!";
    }

    if (empty($product_image)) {
        $e['product_image'] = "image should not be empty....!";
    }

    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($product_name)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $product_name)) {
            $e['product_name'] = "The product name is invalid...!";
        }
        // product name already exsist validation

        $sql_product_name = "SELECT `name` FROM `tb_product` WHERE `name`= '$product_name'";
        $result = $conn->query($sql_product_name);
        if ($result->num_rows > 0) {
            $e['product_name'] = "product name is already exist..";
        }
    }
    if (!empty($description)) {
//        if (!preg_match("/^[a-zA-Z' ]*$/", $description)) {
//            $e['description'] = "The description is invalid...!";
//        }
    }
    //image, upload and validation--------------------
    if (empty($e)) {
        $target_dir = "../images/";
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $e['product_image'] = "File is not an image.";
            $uploadOk = 0;
        }
        
        if (file_exists($target_file)) {
            $e['product_image'] = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        
        if ($_FILES["product_image"]["size"] > 500000) {
            $e['product_image'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $e['product_image'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                $product_image = basename($_FILES["product_image"]["name"]);
            } else {
                $e['product_image'] = "Sorry, there was an error uploading your file.";
            }
        }
    }
    //End advance validation---------------------------
    //Data send to database
    if (empty($e)) {
        $sql = "INSERT INTO `tb_product`(`name`, `discription`, `product_img`) VALUES ('$product_name','$description','$product_image')";

        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Product Ragistration Success!</strong>Data Inserted.

            </div>

            <?php
            //header("Refresh:3");
        } else {
            echo "Error" . $conn->error;
        }
    }
}
?>
<?php
//task assign to product
//Check Page Request Method and task assign
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['operate'] == "assign") {
    //Define variables
    $task = $product = null;

    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------
    $task = $_POST['task'];
    $product = $_POST['product'];

    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($task)) {
        $e['task'] = "The task should not be empty....!";
    }
    if (empty($product)) {
        $e['product'] = "The product should not be empty....!";
    }
    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($task)) {

        // task  already assigned validation
        $sql_username = "SELECT  `product_id`, `task_id` FROM `tb_product_task` WHERE  `product_id`= '$product' AND `task_id`= '$task'";
        $result = $conn->query($sql_username);
        if ($result->num_rows > 0) {
            $e['user_name'] = "task is already assigned..";
            header("Refresh:3");
        }
    }
    //End advance validation---------------------------
    //Database connection assign task
    if (empty($e)) {

        $sql = "INSERT INTO `tb_product_task`(`product_id`, `task_id`) VALUES  ('$product','$task')";

        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Task Assign Success!</strong>Data Inserted.

            </div>

            <?php
            //header("Refresh:3");
        } else {
            echo "Error" . $conn->error;
        }
    }
    //End Database connection assign task
}
?>
<?php
//Check Page Request Method and data edit 
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "edit_product") {
    //Define variables
    $product_id = $product_name = $description = $product_image = $target_dir = $imageFileType = $check = null;
    //Assign data
    $product_id = $_POST['product_id'];
    
    $sql_edit = "SELECT
     tb_product.product_id,
     tb_product.name,
     tb_product.discription,
     tb_product.product_img
     FROM tb_product 
     WHERE product_id='$product_id'";
    $result_edit = $conn->query($sql_edit);
    if ($result_edit->num_rows > 0) {
        while ($row = $result_edit->fetch_assoc()) {
            $product_id = $row['product_id'];
            $product_name = $row['name'];
            $description = $row['discription'];
            $product_image = $row['product_img'];
            $product = $product_id;
        }
    }
}
?>
<?php
//Check Page Request Method post and update status 
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "product_update")) {
    //Define variables
    $product_id = $product_name = $description = $product_image = $target_dir = $imageFileType = $check = null;

    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------
    $product_id = $_POST['product_id'];
    $product_name = ucfirst(clean_input($_POST['product_name']));
    $description = clean_input($_POST['description']);
    $product_image = $_FILES['product_image']["name"];
    $product = $product_id;
    //End assign data----------------------------------
    //Check input fields are empty---------------------

    if (empty($product_name)) {
        $e['product_name'] = "The product name should not be empty....!";
    }
    if (empty($description)) {
        $e['description'] = "The description should not be empty....!";
    }

    if (empty($product_image)) {
        $e['product_image'] = "image should not be empty....!";
    }
    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($product_name)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $product_name)) {
            $e['product_name'] = "The product name is invalid...!";
        }
        // product name already exsist validation

        $sql_product_name = "SELECT `name` FROM `tb_product` WHERE `name`= '$product_name'";
        $result = $conn->query($sql_product_name);
        if ($result->num_rows > 0) {
            $e['product_name'] = "product name is already exist..";
        }
    }
    if (!empty($description)) {
//        if (!preg_match("/^[a-zA-Z:,.-' ]*$/", $description)) {
//            $e['description'] = "The description is invalid...!";
//        }
    }

    //image upload ,delete existing and image validation

    if (empty($e) && isset($product_image)) {


        $target_dir = "../images/";
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $e['product_image'] = "File is not an image.";
            $uploadOk = 0;
        }
        if (file_exists($target_file)) {
            $e['product_image'] = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        if ($_FILES["product_image"]["size"] > 500000) {
            $e['product_image'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $e['product_image'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                $product_image = basename($_FILES["product_image"]["name"]);
                if ($_POST['prv_poduct_image'] != null) {
                    unlink("../images/" . $_POST['prv_poduct_image']);
                }
            } else {
                $e['product_image'] = "Sorry, there was an error uploading your file.";
            }
        }
    }
    //End advance validation---------------------------
    //database connectivity------------------------------
    if (empty($e)) {
        //,`profile_image`='$profile_image'
        $sql = "UPDATE `tb_product` SET `name`='$product_name',`discription`='$description',`product_img`='$product_image' WHERE product_id = '$product_id'";
        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade_show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! product updated</strong>
            </div>
            <?php
            //header("Refresh:3");
        } else {
            echo "Error" . $conn->error;
        }
    }
    //end data send to database------------------------------
}
?>
<!--product registration -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
            <div class="card card-primary ">
                <!--card-header-->
                <div class="card-header">
                    <h3 class="card-title">Product Registration Form</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="product_name">Product Name :</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name" value="<?php echo @$product_name; ?>">
                            <div class="text-danger"><?php echo @$e['product_name']; ?></div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description :</label>

                            <textarea class="form-control" id="description" name="description" placeholder="Enter Description"><?php echo @$description; ?></textarea>
                            <div class="text-danger"><?php echo @$e['description']; ?></div>
                        </div>

                        <div class="form-group">
                            <label for="product_image">Product Image :</label>
                            <div class="input-group custom-file">
                                <input type="file" name="product_image" id="product_image" class="custom-file-input">
                                <label class="custom-file-label" for="chose product image">Choose file</label>
                            </div>

                            <div class="text-danger"><?php echo @$e['product_image']; ?></div>
                            <input type="hidden"  name="prv_poduct_image" value="<?php echo $product_image; ?>" >

                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <?php
                        if (@$_POST['operate'] != "edit_product") {?>
                            <button type="submit" class="btn btn-primary" name="operate" value="product_insert" >Submit</button> <?php
                        }
                        ?>
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" >
                        <?php
                        if (@$_POST['operate'] == "edit_product") { ?>
                            <button type="submit" class="btn btn-primary" name="operate" value="product_update" >Update</button> <?php
                        }
                        ?>
                        <button type="submit" name="operate" value="cancel" class="btn btn-info">Cancel</button> 
                    </div>
                    <!--/.card-footer-->
                </form>
                <!--header 2--> 
                <div class="card-header">
                    <div class="col">
                        <h3 class="card-title">Search</h3>
                    </div>
                </div>
                <!--/.header 2-->
                <div class="card-body  ">
                    <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                        <div class="form-group">

                            <label for="serch_data">Product Name:</label>
                            <div class="input-group-append">
                                <input type="text" class="form-control" id="search" name="search" placeholder="Search" >
                                <button class="btn btn-default" name="operate" type="submit" id="operate" value="search" onmouseover="this.style.color = '#17a2b8 '" onmouseout="this.style.color = '#383f45'">
                                    <i class="fas fa-search "></i>
                                </button>
                            </div>
                            <div class="text-danger"><?php echo @$e['search']; ?></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/.product registration -->


        <!--task assign form-->
        <div class="col-lg">
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Task Assign</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                    <div class="card-body">
                        <div class="form-group">
                            <?php
                            $sql_product = "SELECT `product_id`, `name` FROM `tb_product`";
                            $result_product = $conn->query($sql_product);
                            ?>
                            <label for="product">Product :</label>

                            <select class="form-control select2" name="product" id="product" style="width: 100%;">
                                <option value="">Select existing Product</option>
                                <?php
                                if ($result_product->num_rows > 0) {
                                    while ($row_product = $result_product->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row_product['product_id']; ?>"<?php if (@$product == $row_product['product_id']) { ?> selected<?php } ?> > <?php echo $row_product['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>

                            <div class="text-danger"><?php echo @$e['product']; ?></div>
                        </div>


                        <div class="form-group">
                            <?php
                            $sql_task = "SELECT `task_id`, `name` FROM `tb_task";

                            $result_task = $conn->query($sql_task);
                            ?>
                            <label for="task">Task :</label>


                            <select class="form-control select2" name="task" id="task" style="width: 100%;">
                                <option value="">Select existing Task</option>
                                <?php
                                if ($result_task->num_rows > 0) {
                                    while ($row_task = $result_task->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row_task['task_id']; ?>"<?php if (@$task == $row_task['task_id']) { ?> selected<?php } ?> > <?php echo $row_task['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>

                            <div class="text-danger"><?php echo @$e['task']; ?></div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="operate" value="assign">Assign</button>
                    </div>
                </form>

                <!--card header2-->
                <div class="card-header" >
                    <h3 class="card-title">Task Deny</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="deny_task.php" >
                    <div class="card-body">
                        <div class="form-group">

                            <?php
                            if (!empty($product)) {
                                $sql_task_deny = "SELECT tb_task.task_id, tb_task.name FROM tb_product_task LEFT JOIN tb_task ON tb_task.task_id=tb_product_task.task_id WHERE tb_product_task.product_id = '$product'";
                                $result_task_deny = $conn->query($sql_task_deny);
                            }
                            ?>
                            <label for="task">Task :</label>
                            <select class="form-control select2" name="task" id="task" style="width: 100%;" <?php
                            if (empty($product)) {
                                echo "disabled='disabled'";
                            }
                            ?>>
                                <option value=""><?php
                                    if (empty($product)) {
                                        echo "select edit";
                                    } else {
                                        echo "Select existing Task";
                                    }
                                    ?></option>
                                <?php
                                if ($result_task_deny->num_rows > 0) {
                                    while ($row_task_denay = $result_task_deny->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row_task_denay['task_id']; ?>"<?php if (@$task == $row_task_denay['task_id']) { ?> selected<?php } ?> > <?php echo $row_task_denay['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>



                            <div class="text-danger"><?php echo @$e['task']; ?></div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <input type="hidden" name="product" value="<?php echo $product; ?>">
                        <button type="submit" class="btn btn-primary" name="operate" value="assign">Deny</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
    <?php
    //retrieve list product 
    $sql = "SELECT * FROM `tb_product` ORDER BY `tb_product`.`name` ASC";
    $result_view = $conn->query($sql);

    if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "search") {
        //Define variables
        $search = null;
        //empty validation
        $search = clean_input($_POST['search']);
        if (empty($search)) {
            $e['search'] = "The search value should not be empty....!";
        }
        //advanced validation
        if (!empty($search)) {
            if (!preg_match("/^[a-zA-Z ]*$/", $search)) {
                $e['search'] = "The product name is invalid...!";
            }
        }
        //search 
        if (empty($e)) {
            $sql = "SELECT * FROM `tb_product` WHERE `tb_product`.`name` LIKE '%$search%'";
            $result_view = $conn->query($sql);
        }
    }
    ?>
    <!--view form-->
    <div class="container-fluid">

        <div class="card card-primary">

            <!--card header 2-->
            <div class="card-header">
                <h3 class="card-title">View Product</h3>
            </div> 
            <!-- /.card-header -->
            <div class="card-body">

                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Assigned Tasks</th>
                            <th></th>
                            <th></th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $product_id = $product_name = $description = $product_image = $task = null;
                        if ($result_view->num_rows > 0) {
                            while ($row = $result_view->fetch_assoc()) {
                                $product_id = $row['product_id'];
                                $product_name = $row['name'];
                                $product_image = $row['product_img'];
                                $description = $row['discription'];
                                ?>
                                <tr>

                                    <td><?php echo $product_name; ?></td>
                                    <td><img src="<?php echo ROOT; ?>images/<?php echo $product_image; ?>" alt="profile image" class=" img-rounded" style="opacity: .9" width="90" height="80"></td>

                                    <td><?php
                                        //retrieve assigned task list 

                                        $sql = "SELECT tb_task.name as task_name FROM tb_product_task LEFT JOIN tb_task ON tb_task.task_id=tb_product_task.task_id WHERE tb_product_task.product_id = " . $product_id . "";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {

                                                $task[] = $row['task_name'];
                                            }

                                            foreach ($task as $value) {

                                                echo $value . ",";
                                                echo "<br>";
                                            }

                                            $task = null;
                                        } else {
                                            echo "--";
                                        }
                                        ?></td>
                                    <td>
                                        <div class="input-group-append" >
                                            <form method="post" action="view_product.php">
                                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                                <button type="submit" name="operate" value="view_product" class="btn btn-default" onmouseover="this.style.color = '#A52A2A'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-eye" ></i></button>                   
                                            </form>
                                            </div>
                                    </td>

                                    <td>
                                        <div class="input-group-append">
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" >
                                                <button type="submit" name="operate" value="edit_product" class="btn btn-default" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-edit" ></i></button>                   
                                            </form>
                                                                                    </div>

                                    </td>
                                    <td>
                                        <form method="post" action="delete_product.php">
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                            <input type="hidden" name="product_image" value="<?php echo $product_image; ?>">
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