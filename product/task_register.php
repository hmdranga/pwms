<!--
Page Name: task_register.php
Date Created :08/10/2020
-->
<?php ob_start(); ?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//Check Page Request Method
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate']=="insert" || $_POST['operate'] == "update") ) {

    //Define variables
    $task_id = $task_name = $role_icon = $tool_group = $role = null;

    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------
    if ($_POST['operate'] == "update") {
    $task_id = $_POST['task_id'];
    }
    $task_name = ucfirst(clean_input($_POST['task_name']));
    $role_icon = clean_input($_POST['role_icon']);
    $tool_group = $_POST['tool_group'];
    $role = $_POST['role'];
    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($task_name)) {
        $e['task_name'] = "The task name should not be empty....!";
    }
    if (empty($role_icon)) {
        $e['role_icon'] = "The role icon should not be empty....!";
    }
    if (empty($tool_group)) {
        $e['tool_group'] = "The tool group should not be empty....!";
    }
    if (empty($role)) {
        $e['role'] = "The role should not be empty....!";
    }

    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($task_name)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $task_name)) {
            $e['task_name'] = "The task name is invalid...!";
        }
        if ($_POST['operate'] == "insert") {
        // task name already exsist validation
        $sql_taskname = "SELECT `name` FROM `tb_task` WHERE `name`= '$task_name'";
        $result = $conn->query($sql_taskname);
        if ($result->num_rows > 0) {
            $e['task_name'] = "task name is already exist..";
        }
        }
    }
    if (!empty($role_icon)) {
        if (!preg_match("/^[a-zA-Z- ]*$/", $role_icon)) {
            $e['role_icon'] = "The role icon is invalid...!";
        }
    }
    //End advance validation---------------------------

    if (empty($e)) {
        if ($_POST['operate'] == "insert") {
        $sql = "INSERT INTO `tb_task`(`name`, `role_icon`, `group_code`, `role_code`) VALUES ('$task_name','$role_icon','$tool_group','$role')";

        if ($conn->query($sql) === true) {
          ?>
                <div class="alert alert-success alert-dismissible fade_show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success! data inserted</strong>
                </div>
                <?php
                  $task_name = $role_icon = $tool_group = $role = null;
            
        } else {
            echo "Error" . $conn->error;
        }
    }
    
        elseif ($_POST['operate'] == "update") {
            
            $sql = "UPDATE `tb_task` SET `name`='$task_name',`role_icon`='$role_icon',`group_code`='$tool_group',`role_code`='$role' WHERE `task_id`= '$task_id'";
            if ($conn->query($sql) === true) {
                ?>
                <div class="alert alert-success alert-dismissible fade_show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success! data Updated</strong>
                </div>
                <?php
                $task_id = $task_name = $role_icon = $tool_group = $role = null;
            } else {
                echo "Error" . $conn->error;
            }
        }
    }
}

?>

<?php
//Check Page Request Method and data edit 
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "edit") {
    $task_id = $task_name = $role_icon = $tool_group = $role = null;
    $task_id = $_POST['task_id'];
    $sql_edit ="SELECT  name, role_icon, role_code, group_code FROM `tb_task` WHERE task_id='$task_id'";
    $result_edit = $conn->query($sql_edit);
    if ($result_edit->num_rows > 0) {
        while ($row = $result_edit->fetch_assoc()) {
            $task_name = $row['name'];
            $role_icon = $row['role_icon'];
            $tool_group = $row['group_code'];
            $role = $row['role_code'];
            
        }
    }
}
?>

<div class="container-fluid">
    <!--<div class="row">-->
    <!--        <div class="col-lg">-->
    <div class="card card-primary">

        <div class="card-header">
            <h3 class="card-title">Task Registration Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="task name">Task Name :</label>
                            <input type="text" class="form-control" id="task_name" name="task_name" placeholder="Enter task name" value="<?php echo @$task_name; ?>">
                            <div class="text-danger"><?php echo @$e['task_name']; ?></div>
                        </div>

                        <div class="form-group">
                            <label for="menu_icon">Role Icon :</label>
                            <input type="text" class="form-control" id="role_icon" name="role_icon" placeholder="Enter role icon style name" value="<?php echo @$role_icon; ?>">
                            <div class="text-danger"><?php echo @$e['role_icon']; ?></div>
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="form-group">
                            <?php
                            $sql_toolgroup = "SELECT * FROM `tb_tool_group`";
                            $result_toolgroup = $conn->query($sql_toolgroup);
                            ?>
                            <label for="tool_group">Tool Group :</label>
                            <select class="form-control select2" name="tool_group" id="tool_group" style="width: 100%;">
                                <option value="">Select existing Tool Group</option>
                                <?php
                                if ($result_toolgroup->num_rows > 0) {
                                    while ($row_toolgroup = $result_toolgroup->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row_toolgroup['group_code']; ?>"<?php if (@$tool_group == $row_toolgroup['group_code']) { ?>selected<?php } ?> > <?php echo $row_toolgroup['group']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <div class="text-danger"><?php echo @$e['tool_group']; ?></div>
                        </div>

                        <div class="form-group">
                            <?php
                            $sql_role = "SELECT * FROM tb_role";
                            $result_role = $conn->query($sql_role);
                            ?>
                            <label for="employee role">Employee Role :</label>
                            <select class="form-control select2" name="role" id="role" style="width: 100%;">
                                <option value="">Select existing Employee Group</option>
                                <?php
                                if ($result_role->num_rows > 0) {
                                    while ($row_role = $result_role->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row_role['role_code']; ?>"<?php if (@$role == $row_role['role_code']) { ?> selected<?php } ?> > <?php echo $row_role['role']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <div class="text-danger"><?php echo @$e['role']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
               
                
                <?php
                    if (@$_POST['operate'] != "edit") {
                 ?>
                         <button type="submit" name="operate" value="insert" class="btn btn-primary">Register</button>
                   <?php
                   }
                    ?>

                    <?php
                    if (@$_POST['operate'] == "edit") {
                    ?>
                        <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
                        <button type="submit" name="operate" id="update_btn" value="update"  class="btn btn-primary">Update</button>
                   <?php
                    }
                    ?>
                <button type="submit" name="operate" value="cancel" class="btn btn-info">Cancel</button> 
            </div>
        </form>
        <!--            </div>-->
        <!-- /.card-primary -->
        <!--</div>-->
        <!-- /.col-lg -->
        <?php
        //sql for list table
        $sql_view = "SELECT `task_id`, `name`, `role_icon`, tb_role.`role`, tb_tool_group.`group` FROM `tb_task` LEFT JOIN tb_role ON tb_role.role_code=tb_task.role_code LEFT JOIN tb_tool_group ON tb_tool_group.group_code=tb_task.group_code";
        

        //Check Page Request Method and data search 
        if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "search") {
            //$module_id = $description = $menu_index ;
            $search = $search_type = null;
            //define arry for display error messages
            $e = array();

            //Assign Data--------------------------------------
            echo $search_type = $_POST['search_type'];
            echo $search = clean_input($_POST['search_task']);

            //Check input fields are empty---------------------
            if (empty($search_type)) {
                $e['search_type'] = "The search type should not be empty....!";
            }
            if (empty($search)) {
                $e['search'] = "The search value should not be empty....!";
            }
            //advanced validation
            if (!empty($search_type && $search)) {
                if ($search_type == "name") {
                     if (!preg_match("/^[a-zA-Z ]*$/", $search)) {
                        $e['search'] = "The task name id is invalid...!";
                    }
                }
                if ($search_type == "group") {
                    if (!preg_match("/^[a-zA-Z]*$/", $search)) {
                        $e['search'] = "group name is invalid...!";
                    }
                }
                if ($search_type == "role") {

                    if (!preg_match("/^[a-zA-Z]*$/", $search)) {
                        $e['search'] = "role name is invalid...!";
                    }
                }

                //not exist validation
//                if (empty($e['search'])) {
//                    $sql = "SELECT `$search_type` FROM `tb_user` WHERE `$search_type` LIKE '%$search%'";
//                    $result = $conn->query($sql);
//                    if ($result->num_rows == 0) {
//                        $e['search'] = "enterd data is not exist..";
//                    }
//                }
            }
            if (empty($e)) {
                $sql_view = "SELECT `task_id`, `name`, `role_icon`, tb_role.`role`, tb_tool_group.`group` 
                             FROM `tb_task` 
                             LEFT JOIN tb_role ON tb_role.role_code=tb_task.role_code 
                             LEFT JOIN tb_tool_group ON tb_tool_group.group_code=tb_task.group_code
                             WHERE `$search_type` LIKE '%$search%'";
//                $sql_view = "SELECT `user_id`, `first_name`, `last_name`, `profile_image` FROM `tb_user` WHERE `$search_type` LIKE '%$search%'";
                
            }
        }
        ?>
        <?php
        $result_view = $conn->query($sql_view);
        
        ?>
        <!--<div class="col-lg">-->
        <!--            <div class="card card-primary">-->
        <!--header 2--> 
        <div class="card-header">
            <div class="col">
                <h3 class="card-title">Search</h3>
            </div>
        </div>
        <!--/.header 2-->
        <div class="card-body  ">
            <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="row">
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="search_type">Search Type :</label>
                            <select class="form-control select2"  name="search_type" id="search_type">
                                <option value="">select parameter</option>
                                <option value="name">Task Name</option>
                                <option value="group">Tool Group</option>
                                <option value="role">Employee Role</option>
                            </select>
                            <div class="text-danger"><?php echo @$e['search_type']; ?></div>
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="serch task">Search :</label>
                            <div class="input-group-append">
                                <input type="text" class="form-control" id="search_task" name="search_task" placeholder="Search" >
                                <button class="btn btn-default" name="operate" type="submit" id="operate" value="search" onmouseover="this.style.color = '#17a2b8 '" onmouseout="this.style.color = '#383f45'">
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
    <div class="card-primary">
        <!--card header 2nd-->
        <div class="card-header">
            <h3 class="card-title">View Task</h3>
        </div> 
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>icon</th>
                        <th>Tool Group</th>
                        <th>Role</th>
                        
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
                                <td><?php echo $row['name']; ?></td>
                                <td><i class="<?php echo $row['role_icon']; ?>"></i></td>
                                <td><?php echo $row['group']; ?></td>
                                <td>
                                             <?php echo $row['role']; ?>    
                                </td>
                                
                                <td>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <input type="hidden" name="task_id" value="<?php echo $row['task_id']; ?>">
                                        <button type="submit" name="operate" value="edit" class="btn btn-default" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-edit"></i></button>                   
                                    </form>
                                </td>
                                <td >
                                    <form method="post" action="delete_task.php">
                                        <input type="hidden" name="task_id" value="<?php echo $row['task_id']; ?>">
                                        
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
        <!--./card-body-->
    </div>
    <!--/.card card-primary-->
    <!--</div>-->
    <!--./col-lg-->






    <!--</div>-->
    <!-- /.row -->
</div>
<!-- /.container-fluid -->

<?php include '../footer.php'; ?>
<?php ob_end_flush(); ?>