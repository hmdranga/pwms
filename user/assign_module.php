<!--
Page Name: assign_user.php
Date Created :27/08/2020
-->
<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//insert operation, Check Page Request Method and Which button triggerd
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['operate'] == "insert") {
    //Define variables
    $module_id = $user_name = null;
    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------
    $module_id = clean_input($_POST['module_id']);
    $user_name = clean_input($_POST['user_name']);
    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($module_id)) {
        $e['module_id'] = "The module id should not be empty....!";
    }
    if (empty($user_name)) {
        $e['user_name'] = "The user name should not be empty....!";
    }
    //End check input fields are empty-----------------
    //Advanced validation
    //already exist 
    //Insert data to database--------------------------
    if (empty($e)) {
        $sql = "INSERT INTO `tb_user_module`( `user_id`, `module_id`) VALUES ('$user_name','$module_id')";
        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert"><i class="fas fa-close"></i></button>
                <strong>Success!</strong>Data Inserted.
            </div>
            <?php
            header("Refresh:3");
        } else {
            echo "Error" . $conn->error;
        }
    }
    //End insert data to database-----------------------
}
//end insert operation
//edit operation, Check Page Request Method and Which button triggerd
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['operate'] == "edit") {
    //Define variables
    $module_id = $user_name = null;
    //Assign Data
    $module_id = $_POST['module_id'];
    $user_name = $_POST['user_name'];
}
//end edit operation
?>
<div class="container-fluid">

    <div class="card card-primary ">
        <div class="card-header">
            <h3 class="card-title">User Module Assign Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg">
                        <div class="form-group">
                            <?php
                            $sql_user_select = "SELECT `user_id`, `first_name`, `last_name` FROM `tb_user`";
                            $result_user_select = $conn->query($sql_user_select);
                            ?>
                            <label for="user_name">User Name :</label>
                            <select class="form-control select2" name="user_name" id="user_name" style="width: 100%;">
                                <option value="">Select user</option>
                                <?php
                                if ($result_user_select->num_rows > 0) {
                                    while ($row_user_select = $result_user_select->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $row_user_select['user_id']; ?>"<?php if (@$user_name == $row_user_select['user_id']) { ?>selected <?php } ?>><?php echo $row_user_select['first_name'] . "  " . $row_user_select['last_name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <div class="text-danger"><?php echo @$e['user_name']; ?></div>
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="form-group">

                            <?php
                            $sql_module_id = "SELECT `module_id`, `description` FROM `tb_module`";
                            $result_module_id = $conn->query($sql_module_id);
                            ?>
                            <label for="module_id">Module Id :</label>
                            <select class="form-control select2" name="module_id" id="module_id" style="width: 100%;">
                                <option value="">Select existing module id number</option>
                                <?php
                                if ($result_module_id->num_rows > 0) {
                                    while ($row_module_id = $result_module_id->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $row_module_id['module_id']; ?>"<?php if (@$module_id == $row_module_id['module_id']) { ?>selected <?php } ?>><?php echo $row_module_id['module_id'] . " : " . $row_module_id['description']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>

                            <div class="text-danger"><?php echo @$e['module_id']; ?></div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" name="operate" value="insert" class="btn btn-primary ">Assign</button>
            </div>
        </form>
        <!-- form end -->
    </div>

    <?php
//sql for view  asigned data
    $sql_view = "SELECT
            tb_user.user_id, 
            tb_user.first_name, 
                tb_user.last_name,
                tb_module.module_id,
                tb_module.description
                FROM tb_user_module 
                LEFT JOIN tb_user ON tb_user.user_id=tb_user_module.user_id
                LEFT JOIN tb_module ON tb_module.module_id=tb_user_module.module_id";
    $result_view = $conn->query($sql_view);

//search operation, Check Page Request Method and data search 
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

            if ($search_type == "module_id") {
                //wrong input id validation
                if (!preg_match("/^[0-9]*$/", $search)) {
                    $e['search'] = "The module id is invalid...!";
                }
            }
            if ($search_type == "description") {
                if (!preg_match("/^[a-zA-Z- ]*$/", $search)) {
                    $e['search'] = "The description is invalid...!";
                }
            }

            //not exist validation

            if (empty($e['search'])) {
                if ($search_type <> "module_id") {
                    $sql = "SELECT `$search_type` FROM `tb_user_module`  LEFT JOIN tb_user ON tb_user.user_id=tb_user_module.user_id LEFT JOIN tb_module ON tb_module.module_id=tb_user_module.module_id WHERE`$search_type` LIKE '%$search%'";
                } else {
                    $sql = "SELECT tb_module.`$search_type` FROM `tb_user_module`  LEFT JOIN tb_user ON tb_user.user_id=tb_user_module.user_id LEFT JOIN tb_module ON tb_module.module_id=tb_user_module.module_id WHERE tb_module.`$search_type` LIKE '%$search%'";
                }
                $result = $conn->query($sql);
                if ($result->num_rows == 0) {
                    $e['search'] = "enterd data is not exist..";
                }
            }
        }
        if (empty($e)) {
            if ($search_type <> "module_id") {
                $sql_view = "SELECT
            tb_user.user_id, 
            tb_user.first_name, 
                tb_user.last_name,
                tb_module.module_id,
                tb_module.description
                FROM tb_user_module 
                LEFT JOIN tb_user ON tb_user.user_id=tb_user_module.user_id
                LEFT JOIN tb_module ON tb_module.module_id=tb_user_module.module_id WHERE `$search_type` LIKE '%$search%'";
            } else {
                $sql_view = "SELECT
            tb_user.user_id, 
            tb_user.first_name, 
                tb_user.last_name,
                tb_module.module_id,
                tb_module.description
                FROM tb_user_module 
                LEFT JOIN tb_user ON tb_user.user_id=tb_user_module.user_id
                LEFT JOIN tb_module ON tb_module.module_id=tb_user_module.module_id WHERE tb_module.`$search_type` LIKE '%$search%'";
            }
            $result_view = $conn->query($sql_view);
        }
    }
    ?>
    <div class="card card-primary ">
        <!-- card-header search -->
        <div class="card-header">

            <div class="col">
                <h3 class="card-title">Search</h3>
            </div>
        </div>
        <div class="card-body  ">
            <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="row">
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="search_type">Search Type :</label>
                            <select class="form-control select2"  name="search_type" id="search_type">
                                <option value="">select parameter</option>
                                <option value="first_name">First Name</option>
                                <option value="last_name">Last Name</option>
                                <option value="module_id">Module Id</option>
                                <option value="description">Description</option>

                            </select>
                            <div class="text-danger"><?php echo @$e['search_type']; ?></div>
                        </div>
                    </div>
                    <div class="col-lg">
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
        <!-- card-header view -->
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h3 class="card-title">View</h3>
                </div>
                <div class="col">
                    <?php
                    echo"total records: " . $result_view->num_rows;
                    ?>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive-md">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Module</th>
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
                                    <td><?php echo $row['first_name'] . " " . $row['last_name'] ?></td>
                                    <td><?php echo $row['module_id'] . " : " . $row['description'] ?></td>
                                    <td><?php ?></td>

                                    <td>
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                            <input type="hidden" name="module_id" value="<?php echo $row['module_id']; ?>">
                                            <input type="hidden" name="user_name" value="<?php echo $row['user_id']; ?>">

                                            <button type="submit" name="operate" value="edit" class="btn btn-default" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-edit"></i></button>                   
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post" action="deny_module.php">
                                            <input type="hidden" name="module_id" value="<?php echo $row['module_id']; ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                            <button type="submit" name="operate" value="delete" class="btn btn-default" onmouseover="this.style.color = '#ff1a1a'" onmouseout="this.style.color = '#383f45'"><i class="fa fa-ban"></i></button>                   
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
        </div>
    </div>

</div>

<?php include '../footer.php'; ?>
<?php
ob_end_flush();
?>