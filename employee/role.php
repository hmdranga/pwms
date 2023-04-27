<!--
Page Name: role.php(employee)
Date Created :07/10/2020
-->
<?php ob_start(); ?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//Check Page Request Method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Define variables
    $role_code = $role = null;

    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------
    $role_code = clean_input($_POST['role_code']);
    $role = clean_input($_POST['role']);

    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($role_code)) {
        $e['role_code'] = "The role code should not be empty....!";
    }
    if (empty($role)) {
        $e['role'] = "The role name should not be empty....!";
    }


    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($role_code)) {
        if (!preg_match("/^[a-zA-Z]*$/", $role_code)) {
            $e['role_code'] = "The role code is invalid...!";
        }
        if (strlen($role_code) > 3) {
            $e['role_code'] = "The role code charactor over limit...!";
        }
    }
    if (!empty($role)) {
        if (!preg_match("/^[a-zA-Z]*$/", $role)) {
            $e['role'] = "The role name is invalid...!";
        }
        // group name already exsist validation
        $sql_rolename = "SELECT `group` FROM `tb_tool_group` WHERE `group`= '$role'";
        $result = $conn->query($sql_rolename);
        if ($result->num_rows > 0) {
            $e['role'] = "role name is already exist..";
        }
    }


    //End advance validation---------------------------
    if (empty($e)) {
        $sql = "INSERT INTO `tb_role`(`role_code`, `role`) VALUES ('$role_code','$role')";

        if ($conn->query($sql) === true) {
            echo "Data Inserted";
            header("Refresh:3");
        } else {
            echo "Error" . $conn->error;
        }
    }
}

//sql for view table
$sql_view = "SELECT `role_code`, `role` FROM `tb_role`";
$result_view = $conn->query($sql_view);
?>
<div class="container-fluid">
    <div class="row">
    <div class="card card-primary col-7">
        
        <div class="card-header">
            <h3 class="card-title">Employee Group Addition </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="card-body">
                <div class="form-group">
                    <label for="role code">Role Code :</label>
                    <input type="text" class="form-control" id="role_code" name="role_code" placeholder="Enter employee role code" value="<?php echo @$role_code; ?>">
                    <div class="text-danger"><?php echo @$e['role_code']; ?></div>
                </div>
                <div class="form-group">
                    <label for="employee role name">Role Name :</label>
                    <input type="text" class="form-control" id="role" name="role" placeholder="Enter employee role name" value="<?php echo @$role; ?>">
                    <div class="text-danger"><?php echo @$e['role']; ?></div>
                </div>
                    
                </div>      
            
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            
        </form>
        </div>
        
        <div class="card card-primary col-5">
            <div class="card-header">
                <h3 class="card-title">View role</h3>
            </div> 
            <!-- /.card-header -->
            <div class="card-body">

                <table class="table table-dark">
                    <thead>
                        <tr>

                            <th>code</th>
                            <th>role</th>

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

                                    <td><?php echo $row['role_code']; ?></td>
                                    <td><?php echo $row['role']; ?></td>


        <!--            <td>
        <form method="post" action="edit_module.php">
                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];  ?>">
                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-edit"></i></button>                   
        </form>
        </td>-->

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