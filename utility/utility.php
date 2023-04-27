<!--
Page Name: group.php(equipment)
Date Created :06/10/2020
-->
<?php ob_start(); ?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Tool-Group Addition Form</h3>
                </div>
                <!-- /.card-header -->

                <form id="tool_group_adding_form">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="equipment group name">Tool Group Name :</label>
                            <input type="text" class="form-control" id="group" name="group" placeholder="Enter equipment group name" value="">
                        </div>
                    </div>      
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="button" onclick="tool_group_register()"class="btn btn-primary">Submit</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">View Tool Group</h3>
                </div> 
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-dark">
                        <thead>
                            <tr>                           
                                <th>Tool Group Name</th>
                                <th></th>
                                <th></th>                           
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_view = "SELECT  `group` FROM `tb_tool_group`";
                            $result_view = $conn->query($sql_view);
                            if ($result_view->num_rows > 0) {
                                while ($row = $result_view->fetch_assoc()) {
                                    ?>
                                    <tr>                                    
                                        <td><?php echo $row['group']; ?></td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];         ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-edit fa-xs"></i></button>                   
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];         ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-trash fa-xs"></i></button>                   
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
        <div class="col"> 
            <div id="result"></div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Employee Group Addition </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="employee_role_adding_form">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="employee role name">Role Name :</label>
                            <input type="text" class="form-control" id="role" name="role" placeholder="Enter employee role name" value=" ">

                        </div>

                    </div>      

                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="button" onclick="role_register()" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
        <div class="col">

            <div class="card card-primary ">
                <div class="card-header">
                    <h3 class="card-title">View role</h3>
                </div> 
                <!-- /.card-header -->
                <div class="card-body">

                    <table class="table table-dark">
                        <thead>
                            <tr>


                                <th>Role Name</th>

                                <th></th>
                                <th></th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_view = "SELECT `role_code`, `role` FROM `tb_role`";
                            $result_view = $conn->query($sql_view);
                            if ($result_view->num_rows > 0) {
                                while ($row = $result_view->fetch_assoc()) {
                                    ?>
                                    <tr>


                                        <td><?php echo $row['role']; ?></td>


                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];        ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-edit fa-xs"></i></button>                   
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];         ?>">
                                                <button type="submit" name="operate" value="delete" class="btn btn-default"><i class="fas fa-trash fa-xs"></i></button>                   
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

        <div class="col">
            <div id="result_role"></div>
        </div>

    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Trending Product Assign Form</h3>
                </div>
                <!-- /.card-header -->

                <form id="trending_product_assign_form">
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


                        </div>
                    </div>      
                    <!-- /.card-body -->
                    <div class="card-footer justify-content-end">
                        <button type="button" onclick="trending_product_assign()"class="btn btn-primary">Assign</button>

                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">View Trending Product</h3>
                </div> 
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-dark">
                        <thead>
                            <tr>                           
                                <th>Product Name</th>
                                <th></th>
                                <th></th>                           
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_view = "SELECT  `tb_product`.name FROM `tb_product_trending`LEFT JOIN tb_product ON tb_product.product_id=tb_product_trending.product_id";
                            $result_view = $conn->query($sql_view);
                            if ($result_view->num_rows > 0) {
                                while ($row = $result_view->fetch_assoc()) {
                                    ?>
                                    <tr>                                    
                                        <td><?php echo $row['name']; ?></td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];         ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-edit fa-xs"></i></button>                   
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];         ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-trash fa-xs"></i></button>                   
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
        <div class="col"> 
            <div id="result_trending_product"></div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Discount Product Assign Form</h3>
                </div>
                <!-- /.card-header -->

                <form id="discount_product_assign_form">
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


                        </div>

                        <div class="form-group">
                            <label for="discount">Discount :</label>
                            <div class="input-group-append">
                                <input type="number" class="form-control" id="discount" name="discount" placeholder="Enter discount" value="">
                                <button class="btn btn-default">
                                    <i class="fas fa-percentage"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer justify-content-end">
                        <button type="button" onclick="discount_product_assign()"class="btn btn-primary">Assign</button>

                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">View discount Product</h3>
                </div> 
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-dark">
                        <thead>
                            <tr>                           
                                <th>Product Name</th>
                                <th>Discount</th>
                                <th></th>
                                <th></th>                           
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_view = "SELECT  `tb_product`.name, `tb_product_discount`.discount FROM `tb_product_discount`LEFT JOIN tb_product ON tb_product.product_id=tb_product_discount.product_id";
                            $result_view = $conn->query($sql_view);
                            if ($result_view->num_rows > 0) {
                                while ($row = $result_view->fetch_assoc()) {
                                    ?>
                                    <tr>                                    
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['discount']; ?></td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];         ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-edit fa-xs"></i></button>                   
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];         ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-trash fa-xs"></i></button>                   
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
        <div class="col"> 
            <div id="result_discount_product"></div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Product-Property Addition Form</h3>
                </div>
                <!-- /.card-header -->

                <form id="product_property_form">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="product property">Property :</label>
                            <input type="text" class="form-control" id="property" name="property" placeholder="Enter product property name" value="">
                        </div>
                        <div class="form-group">
                            <label for="product property">Value Type :</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Property_type" id="Property_type" value="R" <?php if (@$Property_type == "R") { ?>checked <?php } ?>>
                                    <label class="form-check-label" for="radio">Radio</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Property_type" id="Property_type" value="C"<?php if (@$Property_type == "C") { ?>checked <?php } ?>>
                                    <label class="form-check-label" for="combo">Combo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Property_type" id="Property_type" value="B"<?php if (@$Property_type == "B") { ?>checked <?php } ?>>
                                    <label class="form-check-label" for="check box">Check box</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Property_type" id="Property_type" value="N"<?php if (@$Property_type == "N") { ?>checked <?php } ?>>
                                    <label class="form-check-label" for="number input">Number</label>
                                </div>
                            </div>
                        </div>
                    </div>      
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="button" onclick="product_property_register()"class="btn btn-primary">Submit</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">View Product Property</h3>
                </div> 
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-dark">
                        <thead>
                            <tr>                           
                                <th>Property</th>
                                <th>Type</th>
                                <th></th>
                                <th></th>                           
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_view = "SELECT  `property`,`type` FROM `tb_product_property`";
                            $result_view = $conn->query($sql_view);
                            if ($result_view->num_rows > 0) {
                                while ($row = $result_view->fetch_assoc()) {
                                    ?>
                                    <tr>                                    
                                        <td><?php echo $row['property']; ?></td>
                                        <td><?php echo $row['type']; ?></td>
                                        <td>
                                            <form method="post" action="edit_property.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];         ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-edit fa-xs"></i></button>                   
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="edit_property.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];         ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-trash fa-xs"></i></button>                   
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
        <div class="col"> 
            <div id="result_product_property"></div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Product-Property Assign Form</h3>
                </div>
                <!-- /.card-header -->

                <form id="product_property_assign_form">
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
                            


                        </div>

                        <div class="form-group">
                            <?php
                            $sql_property = "SELECT `property_id`, `property` FROM `tb_product_property`";
                            $result_property = $conn->query($sql_property);
                            ?>
                            <label for="product">Property :</label>

                            <select class="form-control select2" name="property" id="property" style="width: 100%;">
                                <option value="">Select existing Property</option>
                                <?php
                                if ($result_property->num_rows > 0) {
                                    while ($row_property = $result_property->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row_property['property_id']; ?>"<?php if (@$property == $row_property['property_id']) { ?> selected<?php } ?> > <?php echo $row_property['property']; ?></option>
                                        <?php
                                       
                                    }
                                }
                                ?>
                            </select>
                            

                        </div>

                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer justify-content-end">
                        <button type="button" onclick="product_property_assign()"class="btn btn-primary">Assign</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">View Product-Property value </h3>
                </div> 
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-dark">
                        <thead>
                            <tr>                           
                                <th>Product</th>
                                <th>Property</th>

                                <th></th>
                                <th></th>                           
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_view = "SELECT  `tb_product`.name, `tb_product`.product_id  FROM `tb_product`";
                            $result_view = $conn->query($sql_view);
                            if ($result_view->num_rows > 0) {
                                while ($row = $result_view->fetch_assoc()) {
                                    ?>
                                    <tr>                                    
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php
                                            $sql = "SELECT tb_product_property.property FROM tb_product_property_assign LEFT JOIN tb_product_property ON tb_product_property.property_id=tb_product_property_assign.property_id WHERE tb_product_property_assign.product_id = " . $row['product_id'] . "";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {

                                                    $property[] = $row['property'];
                                                }

                                                foreach ($property as $value) {

                                                    echo $value . ",";
                                                    echo "<br>";
                                                }

                                                $property = null;
                                            } else {
                                                echo "--";
                                            }
                                            ?></td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];         ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-edit fa-xs"></i></button>                   
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];         ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-trash fa-xs"></i></button>                   
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
        <div class="col"> 
            <div id="result_product_property_assign"></div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Product-Property Value Form</h3>
                </div>
                <!-- /.card-header -->

                <form id="product_property_valu_form">
                    <div class="card-body">
                        <div class="form-group">
                            <?php
                            $sql_property = "SELECT `property_id`, `property` FROM `tb_product_property`";
                            $result_property = $conn->query($sql_property);
                            ?>
                            <label for="product">Property :</label>

                            <select class="form-control select2" name="property" id="property" style="width: 100%;">
                                <option value="">Select existing Property</option>
                                <?php
                                if ($result_property->num_rows > 0) {
                                    while ($row_property = $result_property->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row_property['property_id']; ?>"<?php if (@$property == $row_property['property_id']) { ?> selected<?php } ?> > <?php echo $row_property['property']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>

                            <div class="form-group">
                                <label for="product">Value :</label>
                                <input type="text" class="form-control" id="product_value" name="product_value" placeholder="Enter product value" value="" >
                            </div>
                        </div>





                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer justify-content-end">
                        <button type="button" onclick="product_property_value()"class="btn btn-primary">Assign</button>

                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">View Property Value</h3>
                </div> 
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-dark">
                        <thead>
                            <tr>                           
                                <th>Property</th>
                                <th>Value</th>
                                <th></th>
                                <th></th>                           
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_property = "SELECT `property_id`, `property` FROM `tb_product_property`";
                            $result_property = $conn->query($sql_property);
                            if ($result_property->num_rows > 0) {
                                while ($row = $result_property->fetch_assoc()) {
                                    ?>
                                    <tr>                                    
                                        <td><?php echo $row['property']; ?></td>
                                        <td><?php
                                            $sql = "SELECT value FROM tb_product_property_value WHERE property_id = " . $row['property_id'] . "";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {

                                                    $property_value[] = $row['value'];
                                                }

                                                foreach ($property_value as $value) {

                                                    echo $value . ",";
                                                    echo "<br>";
                                                }

                                                $property_value = null;
                                            } else {
                                                echo "--";
                                            }
                                            ?></td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];         ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-edit fa-xs"></i></button>                   
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];         ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-trash fa-xs"></i></button>                   
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
        <div class="col"> 
            <div id="result_product_property_value"></div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Accessory Type Addition</h3>
                </div>
                <!-- /.card-header -->

                <form id="acc_type_form">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="acc_type">Accessory Type Name :</label>
                            <input type="text" class="form-control" id="acc_type" name="acc_type" placeholder="Enter accessory type name" value="">
                        </div>
                    </div>      
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="button" onclick="acc_type_register()"class="btn btn-primary">Submit</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Accessory-type Property Assign</h3>
                </div>
                <!-- /.card-header -->

                <form id="acc_type_prop_assign_form">
                    <div class="card-body">
                        <div class="form-group">
                            <?php
                            $sql = "SELECT `accessory_type_id`, `name` FROM `tb_accessory_type`";

                            $result = $conn->query($sql);
                            ?>
                            <label for="acc_type_name">Accessory Type:</label>

                            <select class="form-control select2" name="acc_type_id" id="acc_type_id" style="width: 100%;">
                                <option value="">Select existing Type</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row_type = $result->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row_type['accessory_type_id']; ?>"<?php if (@$type == $row_type['accessory_type_id']) { ?> selected<?php } ?> > <?php echo $row_type['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <?php
                            $sql_property = "SELECT `property_id`, `property` FROM `tb_product_property`";
                            $result_property = $conn->query($sql_property);
                            ?>
                            <label for="product">Property :</label>

                            <select class="form-control select2" name="prop_id" id="prop_id" style="width: 100%;">
                                <option value="">Select existing Property</option>
                                <?php
                                if ($result_property->num_rows > 0) {
                                    while ($row_property = $result_property->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row_property['property_id']; ?>"<?php if (@$property == $row_property['property_id']) { ?> selected<?php } ?> > <?php echo $row_property['property']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>


                        </div>

                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer justify-content-end">
                        <button type="button" onclick="acc_type_prop_assign()"class="btn btn-primary">Assign</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">View Accessory Type</h3>
                </div> 
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-dark">
                        <thead>
                            <tr>                           
                                <th>Type</th>
                                <th>Property</th>
                                <th></th>
                                <th></th>                           
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_view = "SELECT * FROM `tb_accessory_type` ORDER BY `tb_accessory_type`.`name` ASC";
                            $result_view = $conn->query($sql_view);
                            if ($result_view->num_rows > 0) {
                                while ($row = $result_view->fetch_assoc()) {
                                    ?>
                                    <tr>                                    
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php
                                            $sql = "SELECT tb_product_property.property FROM tb_accessory_type_property LEFT JOIN tb_product_property ON tb_product_property.property_id=tb_accessory_type_property.property_id WHERE tb_accessory_type_property.accessory_type_id = " . $row['accessory_type_id'] . "";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {

                                                    $property[] = $row['property'];
                                                }

                                                foreach ($property as $value) {

                                                    echo $value . ",";
                                                    echo "<br>";
                                                }

                                                $property = null;
                                            } else {
                                                echo "--";
                                            }
                                            ?></td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];          ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-edit fa-xs"></i></button>                   
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];          ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-trash fa-xs"></i></button>                   
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
        <div class="col"> 
            <div id="result_acc_type"></div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Tool Function Creation</h3>
                </div>
                <!-- /.card-header -->

                <form id="tool_func_form">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="acc_type">Tool function :</label>
                            <input type="text" class="form-control" id="func_nm" name="func_nm" placeholder="Enter function name" value="">
                        </div>
                    </div>      
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="button" onclick="tool_func_register()"class="btn btn-primary">Submit</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Tool-group Function Assign</h3>
                </div>
                <!-- /.card-header -->

                <form id="tool_grp_func_form">
                    <div class="card-body">
                        <div class="form-group">
                            <?php
                            $sql = "SELECT * FROM `tb_tool_group`";

                            $result = $conn->query($sql);
                            ?>
                            <label for="tool_grp">Tool Group:</label>

                            <select class="form-control select2" name="tool_grp" id="tool_grp" style="width: 100%;">
                                <option value="">Select existing group</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row_grp = $result->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row_grp['group_code']; ?>"<?php if (@$grp == $row_grp['group_code']) { ?> selected<?php } ?> > <?php echo $row_grp['group']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <?php
                            $sql = "SELECT * FROM `tb_tool_function`";
                            $result_func = $conn->query($sql);
                            ?>
                            <label for="product">Function :</label>

                            <select class="form-control select2" name="func_id" id="func_id" style="width: 100%;">
                                <option value="">Select existing function</option>
                                <?php
                                if ($result_func->num_rows > 0) {
                                    while ($row_func = $result_func->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row_func['function_id']; ?>"<?php if (@$func == $row_func['function_id']) { ?> selected<?php } ?> > <?php echo $row_func['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>


                        </div>

                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer justify-content-end">
                        <button type="button" onclick="tool_grp_func_assign()"class="btn btn-primary">Assign</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">View Tool Function</h3>
                </div> 
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-dark">
                        <thead>
                            <tr>                           
                                <th>Group</th>
                                <th>Function</th>
                                <th></th>
                                <th></th>                           
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_view = "SELECT * FROM `tb_tool_group` ORDER BY `group_code` ASC";
                            $result_view = $conn->query($sql_view);
                            if ($result_view->num_rows > 0) {
                                while ($row = $result_view->fetch_assoc()) {
                                    ?>
                                    <tr>                                    
                                        <td><?php echo $row['group']; ?></td>
                                        <td><?php
                                            $sql = "SELECT tb_tool_function.name FROM tb_tool_group_function LEFT JOIN tb_tool_function ON tb_tool_function.function_id=tb_tool_group_function.function_id WHERE tb_tool_group_function.group_code = " . $row['group_code'];
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {

                                                    $function[] = $row['name'];
                                                }

                                                foreach ($function as $value) {

                                                    echo $value . ",";
                                                    echo "<br>";
                                                }

                                                $function = null;
                                            } else {
                                                echo "--";
                                            }
                                            ?></td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];          ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-edit fa-xs"></i></button>                   
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];          ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-trash fa-xs"></i></button>                   
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
        <div class="col"> 
            <div id="result_tool_func"></div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col">

            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Tool Function Property Assign</h3>
                </div>
                <!-- /.card-header -->

                <form id="func_property_form">
                    <div class="card-body">
                        <div class="form-group">
                            <?php
                            $sql = "SELECT * FROM `tb_tool_function`";

                            $result = $conn->query($sql);
                            ?>
                            <label for="tool_func">Function :</label>

                            <select class="form-control select2" name="tool_func" id="tool_func" style="width: 100%;">
                                <option value="">Select existing function</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row_func = $result->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row_func['function_id']; ?>"<?php if (@$func == $row_func['function_id']) { ?> selected<?php } ?> > <?php echo $row_func['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <?php
                            $sql = "SELECT * FROM `tb_product_property`";
                            $result_prop = $conn->query($sql);
                            ?>
                            <label for="prop">Property :</label>

                            <select class="form-control select2" name="prop" id="prop" style="width: 100%;">
                                <option value="">Select existing property</option>
                                <?php
                                if ($result_prop->num_rows > 0) {
                                    while ($row_prop = $result_prop->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row_prop['property_id']; ?>"<?php if (@$prop == $row_prop['property_id']) { ?> selected<?php } ?> > <?php echo $row_prop['property']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>


                        </div>

                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer justify-content-end">
                        <button type="button" onclick="tool_func_property_assign()"class="btn btn-primary">Assign</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">View Function Property</h3>
                </div> 
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-dark">
                        <thead>
                            <tr>                           
                                <th>Function</th>
                                <th>Property</th>
                                <th></th>
                                <th></th>                           
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_view = "SELECT * FROM `tb_tool_function` ORDER BY `tb_tool_function`.`name` ASC";
                            $result_view = $conn->query($sql_view);
                            if ($result_view->num_rows > 0) {
                                while ($row = $result_view->fetch_assoc()) {
                                    ?>
                                    <tr>                                    
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php
                                            $sql = "SELECT tb_product_property.property FROM tb_function_property LEFT JOIN tb_product_property ON tb_product_property.property_id=tb_function_property.property_id WHERE tb_function_property.function_id = " . $row['function_id'];
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {

                                                    $function[] = $row['property'];
                                                }

                                                foreach ($function as $value) {

                                                    echo $value . ",";
                                                    echo "<br>";
                                                }

                                                $function = null;
                                            } else {
                                                echo "--";
                                            }
                                            ?></td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];          ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-edit fa-xs"></i></button>                   
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="edit_module.php">
                                                <input type="hidden" name="module_id" value="<?php // echo $row['user_id'];          ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default"><i class="fas fa-trash fa-xs"></i></button>                   
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
        <div class="col"> 
            <div id="func_property_result"></div>
        </div>
    </div>
</div> 


<?php include '../footer.php'; ?>
<script type="text/javascript">
    function tool_group_register() {
        var mydata = $("#tool_group_adding_form").serialize();
//   alert(mydata);
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "tool_group.php",
            success: function (data) {
                $("#result").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }

    function role_register() {
        var mydata = $("#employee_role_adding_form").serialize();
//   alert(mydata);
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "role.php",
            success: function (data) {
                $("#result_role").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }

    function trending_product_assign() {
        var mydata = $("#trending_product_assign_form").serialize();
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "trending_product.php",
            success: function (data) {
                $("#result_trending_product").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }

    function discount_product_assign() {
        var mydata = $("#discount_product_assign_form").serialize();
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "discount_product.php",
            success: function (data) {
                $("#result_discount_product").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }

    function product_property_register() {
        var mydata = $("#product_property_form").serialize();
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "product_property.php",
            success: function (data) {
                $("#result_product_property").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }

    function product_property_assign() {
        var mydata = $("#product_property_assign_form").serialize();
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "product_property_assign.php",
            success: function (data) {
                $("#result_product_property_assign").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
    function product_property_value() {
        var mydata = $("#product_property_valu_form").serialize();
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "product_property_value.php",
            success: function (data) {
                $("#result_product_property_value").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }


    function acc_type_register() {
        var mydata = $("#acc_type_form").serialize();
        //alert(mydata);
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "acc_type.php",
            success: function (data) {
                $("#result_acc_type").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }

    function acc_type_prop_assign() {
        var mydata = $("#acc_type_prop_assign_form").serialize();
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "acc_type_prop.php",
            success: function (data) {
                $("#result_acc_type").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }

    function tool_func_register() {
        var mydata = $("#tool_func_form").serialize();
        //alert(mydata);
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "tool_func.php",
            success: function (data) {
                $("#result_tool_func").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }

    function tool_grp_func_assign() {
        var mydata = $("#tool_grp_func_form").serialize();
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "tool_grp_func.php",
            success: function (data) {
                $("#result_tool_func").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }

    function tool_func_property_assign() {
        var mydata = $("#func_property_form").serialize();
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "func_property.php",
            success: function (data) {
                $("#func_property_result").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
</script>