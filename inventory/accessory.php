<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
$type_id = null;
//Edit accessory----------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['operate'] == "edit")) {
    // Define variable----------------------------------------------------------
    $accessory_id = $type_id = null;
    // Assign variable----------------------------------------------------------
    $accessory_id = $_POST['accessory_id'];
    $type_id = $_POST['accessory_type_id'];
    // Data retrive from database-----------------------------------------------
    $sql_edit = "SELECT * FROM `tb_accessory` WHERE accessory_id ='$accessory_id'";
    $result_edit = $conn->query($sql_edit);
    if ($result_edit->num_rows > 0) {
        while ($row = $result_edit->fetch_assoc()) {
            $min_qty = $row['min_qty'];
        }
    }
}
?>

<div class="container-fluid">
    <div id="result"></div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add New Accessory</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="acc_register_form">
            <div class="card-body">
                <div class="form-group">
                    <?php
                    $sql_type = "SELECT * FROM `tb_accessory_type` acct ORDER BY acct.`name` ASC";
                    $result_type = $conn->query($sql_type);
                    ?>
                    <label for="acc_type">Accessory Type :</label>
                    <select class="form-control select2" name="acc_type" id="acc_type" style="width: 100%;" onchange="loadPoperty(this.value);" <?php if (@$_POST['operate'] == "edit") { ?> disabled<?php } ?> >
                        <option value="">Select existing type</option>
                        <?php
                        if ($result_type->num_rows > 0) {
                            while ($row_type = $result_type->fetch_assoc()) {
                                ?>

                                <option value="<?php echo $row_type['accessory_type_id']; ?>"<?php if (@$type_id == $row_type['accessory_type_id']) { ?> selected<?php } ?> > <?php echo $row_type['name']; ?></option>

                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="text-danger"><?php //echo @$e['itmcategory'];          ?></div>
                </div>

                <div id="result_acc_property">
                    
                    <!--Accessory select box property dynamically arrange here-->
                </div>
                <div class="form-group">
                    <label for="acc_min_qty"  class="font-weight-bold" >Minimum Qty :</label>
                    <input type="number" class="form-control" id="acc_min_qty" name="acc_min_qty" value="<?php echo "$min_qty"; ?>"placeholder="Enter minimum qty of unit">   
                    <div class="text-danger"><?php echo @$e['acc_min_qty']; ?></div>
                </div>
              
            </div>
            <div id="result_search"></div>
            <!-- /.card-body -->

            <div class="card-footer">
                <?php
                if (@$_POST['operate'] != "edit") {
                    ?>
                    <button type="button" onclick="acc_register()"class="btn btn-primary">Register</button>
                    <button type="button" onclick="acc_search()"class="btn btn-secondary">Search</button>
                    <?php
                }
                ?>

                <?php
                if (@$_POST['operate'] == "edit") {
                    ?>
                    <input type="hidden" name="accessory_id" value="<?php echo $accessory_id; ?>">
                    <button type="button" class="btn btn-primary" onclick="acc_update()" >Update</button>
                    <?php
                }
                ?>
                <button type="submit" name="operate" value="cancel" class="btn btn-danger">Cancel</button> 
            </div>

        </form>
    </div>
</div>
<?php

 $sql = "SELECT `accessory_id`, acct.name,`min_qty`, acct.accessory_type_id  
         FROM `tb_accessory` acc 
         LEFT JOIN tb_accessory_type acct ON acc.accessory_type_id = acct.accessory_type_id 
         ORDER BY `acct`.`name` ASC";
//search accessory
if (!empty($_SESSION['sql_search'])) {
    
       $sql =  $_SESSION['sql_search'];
   
}

//edit accessory
if (@$_POST['operate'] == "edit") {
    $sql = "SELECT `accessory_id`, `tb_accessory_type`.name,`min_qty`, tb_accessory_type.accessory_type_id 
                FROM `tb_accessory` 
                LEFT JOIN tb_accessory_type ON tb_accessory.accessory_type_id=tb_accessory_type.accessory_type_id
                WHERE accessory_id =" . $accessory_id;
}
$result_view = $conn->query($sql);
?>
<div class="container-fluid">
    <div class="card card-primary ">
        <!-- card-header view -->
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h3 class="card-title">View Accessory</h3>
                </div>
                <div class="col">
                    <?php
                    echo"total records:".$result_view->num_rows;
                    ?>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive-md">
                <table class="table table-hover table-responsive-md table-striped table-head-fixed">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Type</th>
                            <th>Min Qty</th>
                            <th>Properties</th>
                            <th>Qty On Hand</th>
                            <th>Add Stock</th>
                            <th>Use Stock</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_view->num_rows > 0) {
                            while ($row = $result_view->fetch_assoc()) {
                                // stock supplies for each meterial(+)
                                        $sql_rcv = "SELECT SUM(qty) FROM tb_stock WHERE accessory_id =" . $row['accessory_id'];
                                        $result_rcv = $conn->query($sql_rcv);
                                        if ($result_rcv->num_rows > 0) {
                                            $row_rcv = mysqli_fetch_array($result_rcv);
                                            $row_rcv[0];
                                        }
                                        // stock consume for each meerial(-)
                                        $sql_con = "SELECT SUM(`neg_qty` +`pos_qty`) as con FROM `tb_stock_use` WHERE accessory_id = " . $row['accessory_id'];
                                        $result_con = $conn->query($sql_con);
                                        if ($result_con->num_rows > 0) {

                                            $row_con = mysqli_fetch_array($result_con);
                                            $row_con[0];
                                        }
                                        //quntity on hand
                                        $qty_on_hnd = $row_rcv[0] - $row_con[0];
                                        ?>
                                <tr style="<?php if($qty_on_hnd <= $row['min_qty']){ echo "background-color:#b3504b"; } ?>" >
                                    <td><?php echo $row['accessory_id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['min_qty']; ?></td>
                                    <td><?php
                         $sql = "SELECT tb_product_property.property, `tb_product_property_value`.`value` FROM tb_accessory_property
                                LEFT JOIN tb_product_property ON tb_product_property.property_id=tb_accessory_property.property_id
                                LEFT JOIN tb_product_property_value ON tb_product_property_value.property_value_id=tb_accessory_property.property_value_id 
                                WHERE tb_accessory_property.accessory_id = " . $row['accessory_id'];

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row_prop = $result->fetch_assoc()) {

                                echo $row_prop['property'] . " : " . $row_prop['value'];
                                echo "<br>";
                            }
                        } else {
                            echo "--";
                        }
                                ?></td>
                                    <td> <?php echo $qty_on_hnd;?></td>
                                    <td>
                                        <form method="post" action="stock_add.php">
                                            <input type="hidden" name="accessory_id" value="<?php echo $row['accessory_id']; ?>">
                                            <input type="hidden" name="type" value="<?php echo $row['accessory_type_id']; ?>">
                                            <input type="hidden" name="type_nm" value="<?php echo $row['name']; ?>">
                                            <input type="hidden" name="qty_on_hand" value="<?php echo $qty_on_hnd; ?>">

                                            <button type="submit" name="operate" value="stock" class="btn btn-default" onmouseover="this.style.color = '#68D63C'" onmouseout="this.style.color = '#383f45'"><i class="fa fa-plus-circle"></i></button>                   
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post" action="stock_use.php">
                                            <input type="hidden" name="accessory_id" value="<?php echo $row['accessory_id']; ?>">
                                            <input type="hidden" name="type" value="<?php echo $row['accessory_type_id']; ?>">
                                            <input type="hidden" name="type_nm" value="<?php echo $row['name']; ?>">
                                            <input type="hidden" name="qty_on_hand" value="<?php echo $qty_on_hnd; ?>">
                                            <button type="submit" name="operate" value="stock" class="btn btn-default" onmouseover="this.style.color = '#da9ff9'" onmouseout="this.style.color = '#383f45'"> <i class="fas fa-minus-circle"></i> </button>                   
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                                            <input type="hidden" name="accessory_id" value="<?php echo $row['accessory_id']; ?>">
                                            <input type="hidden" name="accessory_type_id" value="<?php echo $row['accessory_type_id']; ?>">
                                            <button type="submit" name="operate" value="edit" class="btn btn-default" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'"> <i class="fas fa-edit"></i> </button>                   
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post" action="acc_dlt.php">
                                            <input type="hidden" name="accessory_id" value="<?php echo $row['accessory_id']; ?>">
                                            <button type="submit" name="operate" value="delete" class="btn btn-default" onmouseover="this.style.color = '#ff1a1a'" onmouseout="this.style.color = '#383f45'"><i class="fa fa-trash-alt"></i></button>                   
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

<?php
include '../footer.php';
unset($_SESSION['sql_search']);
?>
<script type="text/javascript">

    function loadPoperty(accessory_type_id) {
        var mydata = "type_id=" + accessory_type_id + "&";
        // alert(mydata);
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "acc_property_combo.php",
            success: function (data) {
                $("#result_acc_property").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }


    function acc_register() {
        var mydata = $("#acc_register_form").serialize();
//   alert(mydata);
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "acc_process.php",
            success: function (data) {
                $("#result").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }

    function acc_search() {
        var mydata = $("#acc_register_form").serialize();
//   alert(mydata);
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "acc_search.php",
            success: function (data) {
                $("#result_search").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }
    function refreshPage() {
        location.reload(true);
    }


    function acc_update() {
        var mydata = $("#acc_register_form").serialize();
//   alert(mydata);
        $.ajax({
            type: 'POST',
            data: mydata,
            url: "acc_updt.php",
            success: function (data) {
                $("#result").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }


</script>