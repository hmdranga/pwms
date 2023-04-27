<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "view") {
    //Define variables--------------------------------------------------------------------
    $module_id = $description = $module = $view = $menu_index = $menu_icon = $title = null;
    //Assign data(from create module page)-----------------------
    $module_id = $_POST['module_id'];
    //Query for view all details from database-------------------
    $sql = "SELECT * FROM tb_module WHERE module_id='$module_id'";
    $result = $conn->query($sql);
    //Assigning data to variables that got form database
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
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
?>
<div class="row">
    <!--edit button-->
    <form method="post" action="create_module.php">
        <input type="hidden" name="module_id" value="<?php echo $module_id; ?>">
        <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-edit"></i></button>
    </form>
    <!--delete button-->
    <form method="post" action="delete_module.php">
        <input type="hidden" name="module_id" value="<?php echo $module_id; ?>">

        <button type="submit" name="operate" value="delete" class="btn btn-default"><i class="fas fa-trash-alt"></i></button>
    </form>
</div>
<div class="row">
    <table class="table table-bordered bg-info table-striped">
        <tr>
            <th>Module Id</th>
            <td><?php echo $module_id; ?></td>
        </tr>
        <tr>
            <th >Description</th>
            <td><?php echo $description; ?></td>
        </tr>
        <tr>
            <th>Module</th>
            <td><?php
                if (!empty($module)) {
                    echo $module;
                } else {
                    echo"--";
                }
                ?></td>
        </tr>
        <tr>
            <th>File Name (View)</th>
            <td><?php
                if (!empty($view)) {
                    echo $view . ".php";
                } else {
                    echo"--";
                }
                ?></td>
        </tr>
        <tr>
            <th>Menu Index</th>
            <td><?php echo $menu_index; ?></td>
        </tr>
        <tr>
            <th>Menu Icon</th>
            <td><?php if (!empty($menu_icon)) {
                    ?><i class="<?php echo $menu_icon; ?>"></td>
                <?php
            } else {
                echo"--";
            }
            ?>

        </tr>
        <tr>
            <th>Title</th>
            <td><?php
                if (!empty($title)) {
                    echo $title;
                } else {
                    echo"--";
                }
                ?></td>
        </tr>
    </table>
</div>
<?php include '../footer.php'; ?>