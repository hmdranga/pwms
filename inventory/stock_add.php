<?php ob_start(); ?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
// Stock material info----------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "stock") {
    //Define variables----------------------------------------------------------
    $acc_id = $acc_type_id = $type_nm = $qty_on_hand = null;

    //Assign data to sessions (from add.php)------------------------------------
    $_SESSION['accessory_id'] = $_POST['accessory_id'];
    $_SESSION['type_id'] = $_POST['type'];
    $_SESSION['type_nm'] = $_POST['type_nm'];
    $_SESSION['qty_on_hand'] = $_POST['qty_on_hand'];

    //End assign data-----------------------------------------------------------
}
?>
<?php
//Define variables--------------------------------------------------------------
$qty = $sup_id = $pur_date = $ex_date = $unit_price = null;
//Assign data from sessions-----------------------------------------------------
$acc_id = $_SESSION['accessory_id'];
$acc_type_id = $_SESSION['type_id'];
$type_nm = $_SESSION['type_nm'];
$qty_on_hand = $_SESSION['qty_on_hand'];
?>
<?php
//Check Page Request Methord post and operate insert----------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "insert")) {
    //Define variables----------------------------------------------------------
    $qty = $sup_id = $pur_date = $ex_date = $unit_price = null;
    $e = array(); //define arry for display error messages
    //Assign Data---------------------------------------------------------------
    $sup_id = $_POST['supplier'];
    $qty = clean_input($_POST['acc_qty']);
    $pur_date = $_POST['pur_date'];
    $ex_date = $_POST['ex_date'];
    $unit_price = clean_input($_POST['unit_price']);
    date_default_timezone_set('UTC');
    $today = date("Ymd");
    //End assign data-----------------------------------------------------------
    //Check input fields are empty----------------------------------------------
    if (empty($sup_id)) {
        $e['supplier'] = "The supplier should not be empty....!";
    }
    if (empty($qty)) {
        $e['acc_qty'] = "The quntity should not be empty....!";
    }
    if (empty($pur_date)) {
        $e['pur_date'] = "The purchased date should not be empty....!";
    }
    if (empty($ex_date)) {
        $e['ex_date'] = "The expiry date should not be empty....!";
    }
    if (empty($unit_price)) {
        $e['unit_price'] = "The unit price should not be empty....!";
    }
    //End check input fields are empty------------------------------------------
    //Advance validation--------------------------------------------------------
    if (!empty($qty)) {
        if (!is_numeric($qty)) {
            $e['acc_qty'] = "The Quntity is invalid...!";
        }
    }
    if (!empty($unit_price)) {
        if (!is_numeric($unit_price)) {
            $e['unit_price'] = "The Quntity is invalid...!";
        }
    }
  if (!empty($pur_date)) {
      
      if($pur_date>$today){
      $e['pur_date'] = "The purchased date should not be future date....!";
      
      }
    }
    
    //End advance validation----------------------------------------------------
    //data send to database-----------------------------------------------------
    if (empty($e)) {
        $sql = "INSERT INTO `tb_stock`(`accessory_id`, `supplier_id`, `qty`, `remain_qty`, `pur_date`, `ex_date`, `unit_price`, `accessory_type_id`) 
                VALUES ('$acc_id','$sup_id','$qty','$qty','$pur_date','$ex_date','$unit_price','$acc_type_id')";
        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade_show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! stock inserted</strong>
            </div>
            <?php
            header("Refresh:3");
            $sup_id = $qty = $pur_date = $ex_date = $unit_price = null;
        } else {
            echo "Error" . $conn->error;
        }
    }
}
?>
<?php
//Edit supply stock-------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "edit")) {
    // Define variable----------------------------------------------------------
    $stk_id = $qty = $sup_id = $pur_date = $ex_date = $unit_price = null;
    // Assign variable----------------------------------------------------------
    $stk_id = $_POST['stock_id'];
    // Data retrive from database-----------------------------------------------
    $sql_edit = "SELECT * FROM `tb_stock`WHERE stock_id='$stk_id'";
    $result_edit = $conn->query($sql_edit);
    if ($result_edit->num_rows > 0) {
        while ($row = $result_edit->fetch_assoc()) {
            $stk_id = $row['stock_id'];
            $qty = $row['qty'];
            $sup_id = $row['supplier_id'];
            $pur_date = $row['pur_date'];
            $ex_date = $row['ex_date'];
            $unit_price = $row['unit_price'];
        }
    }
}
?>
<?php
//Check Page Request Method post and update status 
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "update")) {
    //Define variables
    $stk_id = $qty = $sup_id = $pur_date = $ex_date = $unit_price = null;
    //define arry for display error messages
    $e = array();
    //Assign Data---------------------------------------------------------------
    $stk_id = $_POST['stk_id'];
    $sup_id = $_POST['supplier'];
    $qty = clean_input($_POST['acc_qty']);
    $pur_date = $_POST['pur_date'];
    $ex_date = $_POST['ex_date'];
    $unit_price = clean_input($_POST['unit_price']);
    //End assign data-----------------------------------------------------------
    
    //Check input fields are empty----------------------------------------------
    if (empty($sup_id)) {
        $e['supplier'] = "The supplier should not be empty....!";
    }
    if (empty($qty)) {
        $e['acc_qty'] = "The quntity should not be empty....!";
    }
    if (empty($pur_date)) {
        $e['pur_date'] = "The purchased date should not be empty....!";
    }
    if (empty($ex_date)) {
        $e['ex_date'] = "The expiry date should not be empty....!";
    }
    if (empty($unit_price)) {
        $e['unit_price'] = "The unit price should not be empty....!";
    }
    //End check input fields are empty------------------------------------------
    //Advance validation--------------------------------------------------------
       if (!empty($qty)) {
        if (!is_numeric($qty)) {
            $e['acc_qty'] = "The Quntity is invalid...!";
        }
    }
    if (!empty($unit_price)) {
        if (!is_numeric($unit_price)) {
            $e['unit_price'] = "The Quntity is invalid...!";
        }
    }
  /* 
   * date validation should be here

   *    */
    //End advance validation----------------------------------------------------
    
    //database connectivity-----------------------------------------------------
    if (empty($e)) {
        $sql = "UPDATE `tb_stock` SET  
                `accessory_id` = '$acc_id',
                `supplier_id` = '$sup_id',
                `qty` = '$qty',
                `remain_qty` = '$qty',
                `pur_date` = '$pur_date',
                `ex_date` = '$ex_date',
                `unit_price` = $unit_price
                WHERE stock_id = '$stk_id'";
        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade_show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! Stock updated</strong>
            </div>
            <?php
            $stk_id = $qty = $sup_id = $pur_date = $ex_date = $unit_price = null;
            //header("Refresh:3");
        } else {
            echo "Error" . $conn->error;
        }
    }
    //end data send to database-------------------------------------------------
}
?>
<a  href="accessory.php"><button type="button" class="btn btn-lg" onmouseover="this.style.color = '#83a95c'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-arrow-alt-circle-left fa-lg" ></i></button></a>               

<div class="row">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <!--material information-->
                        <h6><?php echo"Accessory ID : " . $acc_id; ?> </h6>
                        <h6><?php echo"Accessory Type : " . $type_nm; ?> </h6>
                        <div class="card text-white bg-secondary mb-1" style="max-width: 20rem;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo"Quantity on hand : " . $qty_on_hand; ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col ">
                        <h6 class="float-right">Accessory Property:</h6>
                    </div>
                    <div class="col">
                        <?php
                        //accessory properties data ---------------------------
                        $sql = "SELECT tb_product_property.property, `tb_product_property_value`.`value` 
                                FROM tb_accessory_property
                                LEFT JOIN tb_product_property ON tb_product_property.property_id=tb_accessory_property.property_id
                                LEFT JOIN tb_product_property_value ON tb_product_property_value.property_value_id=tb_accessory_property.property_value_id 
                                WHERE tb_accessory_property.accessory_id = " . $acc_id;
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row_prop = $result->fetch_assoc()) {
                                echo $row_prop['property'] . " : " . $row_prop['value'];
                                echo "<br>";
                            }
                        } else {
                            echo "--";
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Stock Receive</h3>
            </div>
            <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                <div class="card-body">
                    <div class="form-group">
                        <?php
                        //filter supplier who supply each accessory type--------
                        $sql = "SELECT tb_supplier.supplier_id, tb_supplier.`com_nm` FROM tb_suplier_accessory_type
                                LEFT JOIN tb_supplier ON tb_suplier_accessory_type.supplier_id=tb_supplier.supplier_id
                                WHERE tb_suplier_accessory_type.accessory_type_id = " . $acc_type_id;

                        $result_sup = $conn->query($sql);
                        ?>
                        <label for="supplier">Supplier :</label>
                        <select class="form-control select2" name="supplier" id="supplier" style="width: 100%;">
                            <option value="">Select existing Supplier</option>
                            <?php
                            if ($result_sup->num_rows > 0) {
                                while ($row_sup = $result_sup->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row_sup['supplier_id']; ?>"<?php if (@$sup_id == $row_sup['supplier_id']) { ?> selected<?php } ?> > <?php echo $row_sup['com_nm']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="text-danger"><?php echo @$e['supplier']; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="acc_qty"  class="font-weight-bold" >Qty :</label>
                        <input type="number" class="form-control" id="acc_qty" name="acc_qty" value="<?php echo @$qty; ?>" placeholder="Enter qty of accessory"> 
                        <div class="text-danger"><?php echo @$e['acc_qty']; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="pur_date">Purchased Date:</label>
                        <input type="date" class="form-control" id="pur_date" name="pur_date" value="<?php echo @$pur_date; ?>">
                        <div class="text-danger"><?php echo @$e['pur_date']; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="ex_date">Expiry Date:</label>
                        <input type="date" class="form-control" id="ex_date" name="ex_date" value="<?php echo @$ex_date; ?>">
                        <div class="text-danger"><?php echo @$e['ex_date']; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="unit_price"  class="font-weight-bold" >Unit Price :</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rs.</span>
                            </div>
                            <input type="number" step=".0001" class="form-control" name="unit_price" id="unit_price" value="<?php echo $unit_price; ?>" placeholder="Enter Unit Price">
                        </div>
                        <div class="text-danger"><?php echo @$e['unit_price']; ?></div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
               
                    <?php
                    if (@$_POST['operate'] != "edit") {
                        echo'<button type="submit" class="btn btn-primary" name="operate" value="insert" >Add</button>';
                    }
                    ?>

                    <?php
                    if (@$_POST['operate'] == "edit") {
                        ?>
                        <input type="hidden" name="stk_id" value="<?php echo $stk_id; ?>">
                        <?php
                        echo '<button type="submit" class="btn btn-primary" name="operate" value="update" >Update</button>';
                    }
                    ?>
                    <button type="submit" name="operate" value="cancel" class="btn btn-info">Cancel</button> 


                </div>
            </form>
        </div>
    </div>
</div>
<?php 
$sql = "SELECT `stock_id`, tb_supplier.`com_nm`, `qty`, `pur_date`, `ex_date`, `unit_price`
                                FROM `tb_stock` 
                                LEFT JOIN tb_supplier ON tb_stock.supplier_id=tb_supplier.supplier_id 
                                WHERE tb_stock.`accessory_id`= $acc_id";


        // search data function 
        if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "search") {
           
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
                if ($search_type == "com_nm") {
                    if (!preg_match("/^[a-zA-Z ]*$/", $search)) {
                        $e['search'] = "The Supplier name is invalid...!";
                    }
                }
                if ($search_type == "qty") {
                    if (!preg_match("/^[0-9]*$/", $search)) {
                        $e['search'] = "Qty is invalid...!";
                    }
                }
                if ($search_type == "pur_date") {

//                    if (!preg_match("/^[0-9-/ ]*$/", $search)) {
//                        $e['search'] = "date is invalid...!";
//                    }
                }
                if ($search_type == "ex_date") {
//                    if (!preg_match("/^[0-9-/ ]*$/", $search)) {
//                        $e['search'] = "date is invalid...!";
//                    }
                }
                if ($search_type == "unit_price") {
                    if (!preg_match("/^[0-9.]*$/", $search)) {
                        $e['search'] = "Unit price is invalid...!";
                    }
                }
                //not exist validation
                
                if (empty($e['search']) AND ($search_type != "com_nm")) {
                    $sql = "SELECT `$search_type` FROM `tb_stock` WHERE `$search_type` LIKE '%$search%'";
                    $result = $conn->query($sql);
                    if ($result->num_rows == 0) {
                        $e['search'] = "enterd data is not exist..";
                    }
                }
            }
            if (empty($e)) {
                $sql = "SELECT `stock_id`, tb_supplier.`com_nm`, `qty`, `pur_date`, `ex_date`, `unit_price`
                                FROM `tb_stock` 
                                LEFT JOIN tb_supplier ON tb_stock.supplier_id=tb_supplier.supplier_id 
                                WHERE tb_stock.`accessory_id`= $acc_id AND `$search_type` LIKE '%$search%'";
                //$result_view = $conn->query($sql_view);
            }
        }



?>
<!--Stock Receive History view table-->
<div class="row">
    <div class="container-fluid">
        <div class="card card-primary ">
            <!--header 1 search-->
            <div class="card-header">
                    <div class="col">
                        <h3 class="card-title">Search</h3>
                    </div>
                </div>
                <div class="card-body  ">
                    <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                        <div class="col">
                        <div class="form-group">
                            <label for="search_type">Search Type :</label>
                            <select class="form-control select2"  name="search_type" id="search_type">
                                <option value="">select parameter</option>
                                <option value="com_nm">Supplier</option>
                                <option value="pur_date">Purchased date</option>
                                <option value="ex_date">Expiry date</option>
                                <option value="qty">Qty</option>
                                <option value="unit_price">Unit price</option>
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
            
            
            <!-- card-header 2 view -->
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <div class="card-title">Stock Receive History </div>
                    </div>
                    <div class="col"></div>
                    <div class="col">
                        <?php
                        
                        $result_view = $conn->query($sql);
                        echo"Number of records : " . $result_view->num_rows;
                        ?>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <?php ?>
            <div class="card-body">
                <div class="table-responsive-md">
                    <table class="table table-hover table-light">
                        <thead>
                            <tr><th>Recieve ID</th>
                                <th>Supplier</th>
                                <th>Qty</th>
                                <th>Purchased Date</th>
                                <th>Expiry Date</th>
                                <th>Unit Cost (Rs.)</th>
                                <th>Total Cost (Rs.)</th>
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
                                        <td><?php echo $row['stock_id']; ?></td>
                                        <td><?php echo $row['com_nm']; ?></td>
                                        <td><?php echo $row['qty']; ?></td>
                                        <td><?php echo $row['pur_date']; ?></td>
                                        <td><?php echo $row['ex_date']; ?></td>
                                        <td><?php echo $row['unit_price']; ?></td>
                                        <td><?php echo $total_price = $row['qty'] * $row['unit_price']; ?></td>
                                        <td></td>
                                        <td>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                <input type="hidden" name="stock_id" value="<?php echo $row['stock_id']; ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'">
                                                    <i class="fas fa-edit"></i>
                                                </button>                   
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="stock_dlt.php">
                                                 <input type="hidden" name="stock_id" value="<?php echo $row['stock_id']; ?>">
                                                <button type="submit" name="operate" value="delete" class="btn btn-default" onmouseover="this.style.color = '#ff1a1a'" onmouseout="this.style.color = '#383f45'">
                                                    <i class="fa fa-trash-alt"></i>
                                                </button>                   
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
<?php include '../footer.php'; ?>
<script type="text/javascript">
</script>
<?php ob_end_flush(); ?>