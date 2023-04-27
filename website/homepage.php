<!--
Page Name: homepage.php
Date Created :09/12/2020
-->
<?php ob_start(); ?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//product creation
//Check Page Request Method and product register
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['operate'] == "insert") {
$_POST;
    //Define variables
    $com_nm = $logo = $imageFileType = $description = $check = null;
    
    //define arry for display error messages
    $e = array();

    //Assign Data--------------------------------------
    $com_nm = clean_input($_POST['com_nm']);
    $description = clean_input($_POST['description']);
    $logo = $_FILES['logo']["name"];
    //End assign data----------------------------------
    
    //Check input fields are empty---------------------
    if (empty($com_nm)) {
        $e['com_nm'] = "The Company name should not be empty....!";
    }
    if (empty($description)) {
        $e['description'] = "The description should not be empty....!";
    }
    if (empty($logo)) {
        $e['logo_img'] = "image should not be empty....!";
    }
    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($com_nm)) {
//        if (!preg_match("/^[a-zA-Z' ]*$/", $description)) {
//            $e['description'] = "The description is invalid...!";
//        }
    }
    if (!empty($description)) {
//        if (!preg_match("/^[a-zA-Z' ]*$/", $description)) {
//            $e['description'] = "The description is invalid...!";
//        }
    }
    //image, upload and validation--------------------
    if (empty($e)) {
        $target_dir = "../images/";
        $target_file = $target_dir . basename($_FILES["logo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["logo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $e['logo_img'] = "File is not an image.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            $e['logo_img'] = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES["logo"]["size"] > 500000) {
            $e['logo_img'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $e['logo_img'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                $logo = basename($_FILES["logo"]["name"]);
            } else {
                $e['logo_img'] = "Sorry, there was an error uploading your file.";
            }
        }
    }
    //End advance validation---------------------------
    if (empty($e)) {
        $sql = "INSERT INTO `tb_homepg_info`(`name`, `description`, `logo`) VALUES ('$com_nm','$description','$logo')";

        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Homepage information insert Success!</strong>Data Inserted.

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

//Check Page Request Method and operate add
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['operate'] == "add") {
    //Define variables
    $sld_img = $imageFileType = $check = null;

    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------
    $sld_img = $_FILES['sld_img']["name"];
    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($sld_img)) {
        $e['sld_img'] = "The image should not be empty....!";
    }
    //End check input fields are empty-----------------
    
    //image upload ------------------------------------
    if (empty($e)) {
        $target_dir = "../images/web_slide/";
        $target_file = $target_dir . basename($_FILES["sld_img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["sld_img"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $e['sld_img'] = "File is not an image.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            $e['sld_img'] = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES["sld_img"]["size"] > 500000) {
            $e['product_image'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $e['sld_img'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["sld_img"]["tmp_name"], $target_file)) {
                $sld_img = basename($_FILES["sld_img"]["name"]);
            } else {
                $e['sld_img'] = "Sorry, there was an error uploading your file.";
            }
        }
    }
    //End image upload------------------------------
   
    //Database connection assign task
    if (empty($e)) {

        $sql = "INSERT INTO `tb_slideshow_homepg`(`img`) VALUES  ('$sld_img')";

        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Slide show image upload Success!</strong>Data Inserted.
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
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "edit") {
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
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "update")) {
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
<!--home page info mnge -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
            <div class="card card-primary ">
                <!--card-header-->
                <div class="card-header">
                    <h3 class="card-title">Homepage Information Manage Form</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <div class="card-body">

                        <div class="col">
                            <div class="form-group">
                                <label for="com_nm">Company Name :</label>
                                <input type="text" class="form-control" id="com_nm" name="com_nm" placeholder="Enter Company Name" value="<?php echo @$com_nm; ?>">
                                <div class="text-danger"><?php echo @$e['com_nm']; ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Company Description :</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Enter Description"><?php echo @$description; ?></textarea>
                            <div class="text-danger"><?php echo @$e['description']; ?></div>
                        </div>

                        <div class="form-group">
                            <label for="logo">Company logo:</label>
                            <div class="input-group custom-file">
                                <input type="file" name="logo" id="logo" class="custom-file-input">
                                <label class="custom-file-label" for="chose logo image">Choose logo image file</label>
                            </div>

                            <div class="text-danger"><?php echo @$e['logo_img']; ?></div>
                            <input type="hidden"  name="prv_logo" value="<?php echo $logo; ?>" >

                        </div>

                    </div>
                    <!-- /.card-body -->
                     <?php 
                     
                     ?>
                    <div class="card-footer">
                        <?php if (@$_POST['operate'] != "edit" ) { ?>
                            <button type="submit" class="btn btn-primary" name="operate" value="insert" >Submit</button> <?php
                        }
                        ?>
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" >
                        <?php if (@$_POST['operate'] == "edit") { ?>
                            <button type="submit" class="btn btn-primary" name="operate" value="update" >Update</button> <?php
                        }
                        ?>
                        <button type="submit" name="operate" value="edit" class="btn btn-info">Edit</button>

                        <button type="submit" name="operate" value="cancel" class="btn btn-info">Cancel</button> 
                    </div>
                    <!--/.card-footer-->
                </form>
                <!--header 2--> 
                <div class="card-header">
                    <div class="col">
                        <h3 class="card-title">View Homepage information</h3>
                    </div>
                </div>
                <!--/.header 2-->
                <?php 
               $sql_view = "SELECT * FROM `tb_homepg_info`";
               $result_view_home = $conn->query($sql_view);
               if ($result_view_home->num_rows > 0) {
                   $row = $result_view_home->fetch_assoc();
                ?>
                <div class="card-body  ">
                    <table class="table table-bordered bg-gray-dark table-striped">
                        <tr>
                            <td style="width:20%">Company Name :</td>
                            <td><?php echo $row['name']; ?></td>
                        </tr>
                        <tr>
                            <td>Description :</td>
                            <td><?php echo $row['description']; ?></td>
                        </tr>
                        <tr>
                            <td>Logo :</td>
                            <td><img src="<?php echo ROOT; ?>images/<?php echo $row['logo']; ?>" alt="logo_image" class=" img-rounded" style="opacity: .9" width="100" height="90"></td>
                        </tr>
                    </table>
               <?php }?>
                </div>
            </div>
        </div>
        <!--/.product registration -->


        <!--task assign form-->
        <div class="col-lg">
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Slide Show Image Addition Form</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="sld_img">Image :</label>
                            <div class="input-group custom-file">
                                <input type="file" name="sld_img" id="sld_img" class="custom-file-input">
                                <label class="custom-file-label" for="sld_img">Choose image file</label>
                            </div>

                            <div class="text-danger"><?php echo @$e['sld_img']; ?></div>
                            <input type="hidden"  name="prv_sld_img" value="<?php echo $sld_img; ?>" >

                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="operate" value="add">Add</button>
                    </div>
                </form>
                <?php
//view image
                $sql = "SELECT * FROM `tb_slideshow_homepg`";
                $result_view = $conn->query($sql);
                
                ?>
                <!--card header2-->
                <div class="card-header" >
                    <h3 class="card-title">View Slideshow Image</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>image</th>
                            <th>Active</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        if ($result_view->num_rows > 0) {
                            while ($row = $result_view->fetch_assoc()) {     
                                
                                ?>
                                <tr>
                                    <td><img src="<?php echo ROOT; ?>images/<?php echo $row['img']; ?>" alt="slideshow image" class=" img-rounded" style="opacity: .9" width="90" height="80"></td>
                                    <td>
                                        <div class="input-group-append">
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                <input type="hidden" name="slideshow_id" value="<?php echo $row['slideshow_id']; ?>" >
                                                <button type="submit" name="operate" value="edit_product" class="btn btn-default" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-dot-circle" ></i></button>                   
                                            </form>
                                        </div>

                                    </td>
                                    <td>
                                        <form method="post" action="deletet.php">
                                            <input type="hidden" name="slideshow_id" value="<?php echo $row['slideshow_id']; ?>">
                                            
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
   
</div>
<?php include '../footer.php'; ?>
<?php ob_end_flush(); ?>