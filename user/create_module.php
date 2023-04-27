<!--
Page Name: create_module.php
Date Created: 2020-08-28
Date last modified: 2020-10-21
-->

<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//Check Page Request Method and data insert 
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "insert" || $_POST['operate'] == "update")) {

    //Define variables
    $module_id = $description = $module = $view = $menu_index = $menu_icon = $title = null;
    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------
    $module_id = clean_input($_POST['module_id']);
    $description = clean_input($_POST['description']);
    $module = clean_input($_POST['module']);
    $view = clean_input($_POST['view']);
    $menu_index = clean_input($_POST['menu_index']);
    $menu_icon = clean_input($_POST['menu_icon']);
    $title = clean_input($_POST['title']);
    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($module_id)) {
        $e['module_id'] = "The module id should not be empty....!";
    }
    if (empty($description)) {
        $e['description'] = "The description should not be empty....!";
    }
    if (empty($menu_index)) {
        $e['menu_index'] = "The menu index should not be empty....!";
    }
    if (empty($menu_icon)) {
        $e['menu_icon'] = "The menu icon should not be empty....!";
    }
    //End check input fields are empty-----------------
    //Advance validation-------------------------------
    if (!empty($module_id)) {
        if (!preg_match("/^[0-9]*$/", $module_id)) {
            $e['module_id'] = "The module id is invalid...!";
        }
//        if(strlen($module_id)<>2 or strlen($module_id)<>4 ){
//            $e['module_id'] = "Module id should be 2 or 4 characters..";
//        }
//        
        //allready exist validation
        if ($_POST['operate'] == "insert") {
            $sql_moduleid = "SELECT `module_id` FROM `tb_module` WHERE `module_id`= '$module_id'";
            $result = $conn->query($sql_moduleid);
            if ($result->num_rows > 0) {
                $e['module_id'] = "Module id is already exist..";
            }
        }
    }
    if (!empty($description)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $description)) {
            $e['description'] = "The description is invalid...!";
        }
    }
    if (!empty($module)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $module)) {
            $e['module'] = "The module is invalid...!";
        }
    }
    if (!empty($view)) {
        if (!preg_match("/^[a-zA-Z_ ]*$/", $view)) {
            $e['view'] = "The view is invalid...!";
        }
    }
    if (!empty($menu_index)) {
        if (!preg_match("/^[0-9]*$/", $menu_index)) {
            $e['module'] = "The module is invalid...!";
        }
    }
    if (!empty($menu_icon)) {
        if (!preg_match("/^[a-zA-Z- ]*$/", $menu_icon)) {
            $e['menu_icon'] = "The menu icon is invalid...!";
        }
    }
    if (!empty($title)) {
        if (!preg_match("/^[a-zA-Z ]*$/", $title)) {
            $e['title'] = "The title is invalid...!";
        }
    }
    //End advance validation---------------------------
    //Database insertion and update
    if (empty($e)) {
        if ($_POST['operate'] == "insert") {
            $sql = "INSERT INTO `tb_module`(`module_id`, `description`, `module`, `view`, `menu_index`, `menu_icon`, `title`) VALUES ('$module_id','$description','$module','$view','$menu_index','$menu_icon','$title')";
            if ($conn->query($sql) === true) {
                ?>
                <div class="alert alert-success alert-dismissible fade_show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success! data inserted</strong>
                </div>
                <?php
                $module_id = $description = $module = $view = $menu_index = $menu_icon = $title = null;
            } else {
                echo "Error" . $conn->error;
            }
        } elseif ($_POST['operate'] == "update") {
            $sql = "UPDATE `tb_module` SET `description`='$description',`module`='$module',`view`='$view',`menu_index`='$menu_index',`menu_icon`='$menu_icon',`title`='$title' WHERE module_id = '$module_id'";
            if ($conn->query($sql) === true) {
                ?>
                <div class="alert alert-success alert-dismissible fade_show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success! data Updated</strong>
                </div>
                <?php
                $module_id = $description = $module = $view = $menu_index = $menu_icon = $title = null;
            } else {
                echo "Error" . $conn->error;
            }
        }
    }
    //End Database insertion  
}

//Check Page Request Method and data edit 
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "edit") {
    //Define variables
    $module_id = $description = $module = $view = $menu_index = $menu_icon = $title = null;
    $module_id = $_POST['module_id'];
    $sql_edit = "SELECT
     tb_module.module_id,
     tb_module.description,
     tb_module.module,
     tb_module.view,
     tb_module.menu_index,
     tb_module.menu_icon,
     tb_module.title
     FROM tb_module 
     WHERE module_id='$module_id'";
    $result_edit = $conn->query($sql_edit);
    if ($result_edit->num_rows > 0) {
        while ($row = $result_edit->fetch_assoc()) {
            $module_id = $row['module_id'];
            $description = $row['description'];
            $module = $row['module'];
            $view = $row['view'];
            $menu_index = $row['menu_index'];
            $menu_icon = $row['menu_icon'];
            $title = $row['title'];
        }
    }
}

if (@$_POST['operate'] == "cancel") {
    $module_id = $description = $module = $view = $menu_index = $menu_icon = $title = null;
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
        <div class="card card-primary" >
            <!-- card-header -->
            <div class="card-header ">
                <h3 class="card-title">Module Creation Form</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="post"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="card-body">
                    <div class="form-group">
                        <label for="module_id">Module Id :</label>
                        <input type="text" class="form-control" id="module_id" name="module_id" placeholder="Enter module id number" value="<?php echo @$module_id; ?>">
                        <div class="text-danger"><?php echo @$e['module_id']; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description :</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Enter description" value="<?php echo @$description; ?>">
                        <div class="text-danger"><?php echo @$e['description']; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="module">Parent Module Name :</label>
                        <input type="text" class="form-control" id="module" name="module" placeholder="Enter module name (folder name)" value="<?php echo @$module; ?>">
                        <div class="text-danger"><?php echo @$e['module']; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="view">Sub Module Name :</label>
                        <input type="text" class="form-control" id="view" name="view" placeholder="Enter sub-module name (file name)" value="<?php echo @$view; ?>">
                        <div class="text-danger"><?php echo @$e['view']; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="menu_index">Menu Index :</label>
                        <input type="text" class="form-control" id="menu_index" name="menu_index" placeholder="Enter menu index number" value="<?php echo @$menu_index; ?>">
                        <div class="text-danger"><?php echo @$e['menu_index']; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="menu_icon">Menu Icon :</label>
                        <input type="text" class="form-control" id="menu_icon" name="menu_icon" placeholder="Enter menu icon style name" value="<?php echo @$menu_icon; ?>">
                        <div class="text-danger"><?php echo @$e['menu_icon']; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="title">Title :</label>
                        <input type="text" class="form-control" id="user_name" name="title" placeholder="Enter title" value="<?php echo @$title; ?>">
                        <div class="text-danger"><?php echo @$e['title']; ?></div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer align-content-center">
                    <button type="submit" name="operate" id="submit_btn" value="insert" class="btn btn-primary" > Submit </button>
                    <button type="submit" name="operate" id="update_btn" value="update"  class="btn btn-primary">Update</button>
                    <button type="submit" name="operate" value="cancel" class="btn btn-info">Cancel</button> 
                </div>
            </form>
            <!-- form end -->
        </div>
        </div>
        <?php
//sql for view list table
        $sql_view = "SELECT `module_id`, `description`, `menu_index` FROM `tb_module`";
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
                if ($search_type == "mid") {
                    //wrong input id validation
                    if (!preg_match("/^[0-9]*$/", $search)) {
                        $e['search'] = "The module id is invalid...!";
                    }

                    //not exsist validation

                    if (empty($e['search'])) {
                        $sql_moduleid = "SELECT `module_id` FROM `tb_module` WHERE `module_id`= '$search'";
                        $result = $conn->query($sql_moduleid);
                        if ($result->num_rows == 0) {
                            $e['search'] = "enterd module id is not exist..";
                        } else {
                            $search_type = "module_id";
                        }
                    }
                }
                if ($search_type == "des") {

                    //wrong input description
                    if (!preg_match("/^[a-zA-Z- ]*$/", $search)) {
                        $e['search'] = "The description is invalid...!";
                    }
                    //not exsist validation
                    if (empty($e['search'])) {
                        $sql_description = "SELECT `description` FROM `tb_module` WHERE `description` LIKE '%$search%'";
                        $result = $conn->query($sql_description);
                        if ($result->num_rows == 0) {
                            $e['search'] = "enterd module id is not exist..";
                        } else {
                            $search_type = "description";
                        }
                    }
                }
            }


            if (empty($e)) {
                $sql_view = "SELECT `module_id`, `description`, `menu_index` FROM `tb_module` WHERE `$search_type` LIKE '%$search%'";
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
                            <option value="mid">Module ID</option>
                            <option value="des">Description</option>
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
            <!-- card-header 2d -->
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h3 class="card-title">View Module</h3>
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
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>Module Id</th>
                            <th>Description</th>
                            <th>Menu Index</th>
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
                                    <td><?php echo $row['module_id'] ?></td>
                                    <td><?php echo $row['description'] ?></td>
                                    <td><?php echo $row['menu_index'] ?></td>
                    
                                    <td >
                                        <form method="post" action="view_module.php">
                                            <input type="hidden" name="module_id" value="<?php echo $row['module_id']; ?>">
                                            <button type="submit" name="operate" value="view" class="btn btn-default" onmouseover="this.style.color = '#cad315'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-eye"></i></button>         
                                        </form>
                                    </td>
                    
                                    <td >
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                            <input type="hidden" name="module_id" value="<?php echo $row['module_id']; ?>">
                                            <button type="submit" name="operate" value="edit" class="btn btn-default" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-edit "></i></button>                   
                                        </form>
                                    </td>
                                   
                                    <td>
                                        <form method="post" action="delete_module.php">
                                            <input type="hidden" name="module_id" value="<?php echo $row['module_id']; ?>">
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
            </div>
        </div>
        </div>
    </div>
</div>
<?php include '../footer.php'; ?>
<script type="text/javascript">

    function edit_data() {
        $("#update_btn").show();
        $("#submit_btn").hide();

    }
</script>
