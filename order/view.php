<!--
Page Name: add.php(order)
Date Created :25/12/2020
-->
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php

//sql for list table
$sql_view = "SELECT * FROM `tb_order`";


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
        if ($search_type == "order_id") {
            if (!is_numeric($search)) {
                $e['search'] = "Order id is invalid...!";
            }
        }
       
        if ($search_type == "email") {
            if (!filter_var($search, FILTER_VALIDATE_EMAIL)) {
                $e['search'] = "entered email is invalid...!";
            }
        }
        if ($search_type == "cus_name") {

            if (!preg_match("/^[a-zA-Z ]*$/", $search)) {
                $e['search'] = "entered name is invalid...!";
            }
        }
        
        //not exist validation
        if (empty($e['search'])) {
            $sql = "SELECT `$search_type` FROM `tb_order` WHERE `$search_type` LIKE '%$search%'";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                $e['search'] = "entered data is not exist..";
            }
        }
    }
    if (empty($e)) {
        $sql_view = "SELECT * FROM `tb_order` WHERE `$search_type` LIKE '%$search%'";
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
                                <option value="email">email</option>
                                <option value="order_id">Order Id</option>
                                <option value="cus_name">Customer Name</option>
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
                <h3 class="card-title"><i class="fas fa-users"></i> View Order</h3>
            </div>
            <div class="col">
                <?php
                echo"Order count: " . $result_view->num_rows;
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
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>email</th>
                        <th>Status</th>
                        
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_view->num_rows > 0) {
                        while ($row = $result_view->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['order_id']; ?></td>
                                <td><?php 
                                $sql="SELECT  `name` FROM `tb_product` WHERE `product_id`=".$row['product_id']."";
                                $result = $conn->query($sql)->fetch_assoc();
                                echo $result['name']." ( ". $row['qty']." )"; 
                                ?>
                                </td>
                                <td><?php echo $row['cus_name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php
                                if( $row['order_status']== "PRE"){
                                    echo"Pre-Order";
                                 }elseif ($row['order_status']== "PRO") {
                                               echo"Order Processing" ; 
                                            }elseif ($row['order_status']== "FIN") {
                                                echo "Order Is Redy";
                                            }elseif ($row['order_status']== "DONE") {
                                                echo "DONE ";
                                            }?></td>
                                <td >
                                    <form method="post" action="list.php">
                                        <input type="hidden" name="order_id" id="order_id" value="<?php echo $row['order_id']; ?>">
                                        <input type="hidden" name="product" id="product" value="<?php echo $result['name']; ?>">
                                        <button type="submit" name="operate" value="view" class="btn btn-default" onmouseover="this.style.color = '#cad315'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-eye"></i></button>         
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
