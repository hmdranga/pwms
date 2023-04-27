<?php ob_start(); ?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "stock") {
    //Define variables----------------------------------------------------------
    $acc_id = $acc_type_id = $type_nm = $qty_on_hand = null;

    //Assign data to sessons (from add.php)-------------------------------------
    $_SESSION['accessory_id'] = $_POST['accessory_id'];
    $_SESSION['type_id'] = $_POST['type'];
    $_SESSION['type_nm'] = $_POST['type_nm'];
    $_SESSION['qty_on_hand'] = $_POST['qty_on_hand'];
    //End assign data-----------------------------------------------------------
}
//Define variables----------------------------------------------------------
$order_id = $pos_qty = $neg_qty = $con_date = $note = null;
//Assign data from sessions-------------------------------------------------
$acc_id = $_SESSION['accessory_id'];
$acc_type_id = $_SESSION['type_id'];
$type_nm = $_SESSION['type_nm'];
$qty_on_hand = $_SESSION['qty_on_hand'];
 date_default_timezone_set('UTC');
    $today = date("Ymd");
//Check Page Request Methord post and operate insert----------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "insert")) {
    //Define variables
    $order_id  = $neg_qty = $con_date = $note = null;
    $e = array(); //define arry for display error messages
    //Assign Data---------------------------------------------------------------
    $order_id = $_POST['order'];
    
    $neg_qty = clean_input($_POST['neg_qty']);
    $con_date = $_POST['con_date'];
    $note = clean_input($_POST['note']);

    //End assign data-----------------------------------------------------------
    //Check input fields are empty----------------------------------------------

    if (empty($order_id)) {
        $e['order'] = "The order should not be empty....!";
    }
    
    if (empty($neg_qty)) {
        $e['neg_qty'] = "The negative qty should not be empty....!";
    }
    if (empty($con_date)) {
        $e['con_date'] = "The consume date should not be empty....!";
    }

    //End check input fields are empty------------------------------------------
    //Advance validation--------------------------------------------------------
  
    if (!empty($neg_qty)) {
        if (!is_numeric($neg_qty)) {
            $e['neg_qty'] = "The Quntity is invalid...!";
        }
        if($neg_qty <= 0){
            $e['neg_qty'] = "The Quntity should be positive number..!";
        }
    }
     if (!empty($con_date)) {
        if($con_date > $today){
            $e['con_date'] = "The consume date can't be future date..!";
        }
    }
    if (!empty($note)) {
//      if (!preg_match("/^[a-zA-Z0-9 ]*$/", $description)) {
//            $e['description'] = "The description is invalid...!";
//        }
    }

    //End advance validation----------------------------------------------------


    if (empty($e)) {

        $sql = "INSERT INTO `tb_stock_use`(`accessory_id`, `order_id`, `con_date`, `neg_qty`, `pos_qty`, `note`) VALUES ('$acc_id','$order_id','$con_date','$neg_qty','$pos_qty','$note')";
        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade_show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! stock Consumed.. </strong>
            </div>
            <?php
            header("Refresh:3");
            $order_id = $pos_qty = $neg_qty = $con_date = $note = null;
        } else {
            echo "Error" . $conn->error;
        }
    }
}
?>
<?php
//Edit consume stock-------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "edit")) {
    // Define variable----------------------------------------------------------
    $stock_use_id = $order_id = $pos_qty = $neg_qty = $con_date = $note = null;
    // Assign variable----------------------------------------------------------
    $stock_use_id = $_POST['stock_use_id'];
    // Data retrive from database-----------------------------------------------
    $sql_edit = "SELECT * FROM `tb_stock_use`WHERE stock_use_id='$stock_use_id'";
    $result_edit = $conn->query($sql_edit);
    if ($result_edit->num_rows > 0) {
        while ($row = $result_edit->fetch_assoc()) {
            $stock_use_id = $row['stock_use_id'];
            $order_id = $row['order_id'];
           
            $neg_qty = $row['neg_qty'];
            $con_date = $row['con_date'];
            $note = $row['note'];
        }
    }
}
?>
<?php
//Check Page Request Method post and update status 
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "update")) {
    //Define variables
    $stock_use_id = $order_id = $pos_qty = $neg_qty = $con_date = $note = null;
    //define arry for display error messages
    $e = array();
    //Assign Data---------------------------------------------------------------
    $stock_use_id = $_POST['stock_use_id'];
    $order_id = $_POST['order'];
//    $pos_qty = clean_input($_POST['pos_qty']);
    $neg_qty = clean_input($_POST['neg_qty']);
    $con_date = $_POST['con_date'];
    $note = clean_input($_POST['note']);
    date_default_timezone_set('UTC');
    $today = date("Ymd");
    //End assign data-----------------------------------------------------------
    //Check input fields are empty----------------------------------------------
    if (empty($order_id)) {
        $e['order'] = "The order should not be empty....!";
    }
    if (empty($neg_qty)) {
        $e['neg_qty'] = "The negative qty should not be empty....!";
    }
    if (empty($con_date)) {
        $e['con_date'] = "The consume date should not be empty....!";
    }
    //End check input fields are empty------------------------------------------
    //Advance validation--------------------------------------------------------
    if (!empty($neg_qty)) {
        if (!is_numeric($neg_qty)) {
            $e['neg_qty'] = "The Quntity is invalid...!";
        }
        if($neg_qty <= 0){
            $e['neg_qty'] = "The Quntity should be positive number..!";
        }
    }
    
    if (!empty($con_date)) {
        if($con_date > $today){
            $e['con_date'] = "The consume date can't be future date..!";
        }
    }
    
   
    //End advance validation----------------------------------------------------
    //database connectivity-----------------------------------------------------
    if (empty($e)) {
        $sql = "UPDATE `tb_stock_use` SET 
            `order_id`='$order_id',
            `con_date`='$con_date',
            `neg_qty`='$neg_qty',
          
            `note`='$note'
            WHERE stock_use_id = '$stock_use_id'";
        if ($conn->query($sql) === true) {
            ?>
            <div class="alert alert-success alert-dismissible fade_show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! Consume data updated</strong>
            </div>
            <?php
             $stock_use_id = $order_id  = $neg_qty = $con_date = $note = null;
           
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
$sql = "SELECT tb_product_property.property, `tb_product_property_value`.`value` FROM tb_accessory_property
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

                <h3 class="card-title">Stock Consumption</h3>
            </div>

            <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                <div class="card-body">


                    <div class="form-group">
<?php
$sql = "SELECT * FROM `tb_order`  WHERE order_status != 'DONE' && order_status != 'PRE' ORDER BY `tb_order`.`order_id` DESC";

$result = $conn->query($sql);
?>
                        <label for="order"> Order ID :</label>
                        <select class="form-control select2" name="order" id="order" style="width: 100%;">
                            <option value="">Select Order</option>
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>

                                    <option value="<?php echo $row['order_id']; ?>"<?php if (@$order_id == $row['order_id']) { ?> selected<?php } ?> > <?php echo $row['order_id'] ; ?></option>

        <?php
    }
}
?>
                        </select>
                        <div class="text-danger"><?php echo @$e['order']; ?></div>
                    </div>



                    <div class="form-group">
                        <label for="neg_qty"  class="font-weight-bold" >Negative Qty :</label>
                        <input type="number" class="form-control" id="neg_qty" name="neg_qty" value="<?php echo $neg_qty; ?>" placeholder="Enter negative use qty of accessory"> 
                        <div class="text-danger"><?php echo @$e['neg_qty']; ?></div>
                    </div>

                    <div class="form-group">
                        <label for="con_date">Consume Date:</label>
                        <input type="date" class="form-control" id="con_date" name="con_date" value="<?php echo @$con_date; ?>">
                        <div class="text-danger"><?php echo @$e['con_date']; ?></div>
                    </div>

                    <div class="form-group">
                        <label for="note"  class="font-weight-bold" >Note :</label>
                        <div class="input-group">
                            <textarea class="form-control" id="note" name="note" placeholder="Enter note if necessary"><?php echo @$note; ?></textarea>
                        </div>
                        <div class="text-danger"><?php echo @$e['note']; ?></div>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
<?php
if (@$_POST['operate'] != "edit") {
    echo'<button type="submit" class="btn btn-primary" name="operate" value="insert" >Consume</button>';
}
?>

                    <?php
                    if (@$_POST['operate'] == "edit") {
                        ?>
                        <input type="hidden" name="stock_use_id" value="<?php echo $stock_use_id; ?>">
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


<div class="row">
    <div class="container-fluid">
        <div class="card card-primary ">
            <!-- card-header view -->
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <div class="card-title">Stock Consume History </div>
                    </div>
                    <div class="col"></div>
                    <div class="col">
<?php
$sql = "SELECT `stock_use_id`, `order_id`, `con_date`, `neg_qty`, `pos_qty`, `note` FROM `tb_stock_use` WHERE `accessory_id`= $acc_id";
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
                    <table class="table table-hover table-dark">
                        <thead>
                            <tr><th>Consume ID</th>
                                <th>Order ID</th>
                                <th>Consume Date</th>
                                <th>Positive Qty</th>
                                <th>Negative Qty</th>
                                <th>Note</th>
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
                                        <td><?php echo $row['stock_use_id']; ?></td>
                                        <td><?php echo $row['order_id']; ?></td>
                                        <td><?php echo $row['con_date']; ?></td>
                                        <td><?php echo $row['pos_qty']; ?></td>
                                        <td><?php echo $row['neg_qty']; ?></td>
                                        <td><?php echo $row['note']; ?></td>
                                        <td>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                <input type="hidden" name="stock_use_id" value="<?php echo $row['stock_use_id']; ?>">
                                                <button type="submit" name="operate" value="edit" class="btn btn-default" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'">
                                                    <i class="fas fa-edit"></i>
                                                </button>                   
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="stock_use_dlt.php">
                                                <input type="hidden" name="stock_use_id" value="<?php echo $row['stock_use_id']; ?>">
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