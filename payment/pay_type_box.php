<?php
include '../conn.php';
$sql = "SELECT * FROM `tb_order` WHERE  order_id ='" . $_POST['order_id'] . "'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>
<input type="hidden" value="<?php echo $row['product_id']; ?>" name="pro_id" id="pro_id">
<input type="hidden" value="<?php echo $row['qty']; ?>" name="qty" id="qty">
<div class="card-header">
    <div class="row">
        <div class="col">
            <h5>Order Details</h5>
        </div>

    </div>
</div>
<!-- /.card-header -->
<div class="card-body">
     
    <table class="table table-hover table-responsive-md table-striped table-bordered">

        <tbody>                     
            <tr>
                <td>Product (qty) </td>
                <?php
                $sql = "SELECT * FROM `tb_product` WHERE  product_id ='" . $row['product_id'] . "'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row_pro_nm = $result->fetch_assoc();
                }
                ?>
                <td><?php echo $row_pro_nm['name'] . " ( " . $row['qty'] . " )"; ?></td>                                
            </tr>
            <tr>
                <td>Customer Name </td>

                <td> 
                    <?php
                    if ($row['cus_id'] != 0) {
                        $sql = "SELECT * FROM `tb_customer` WHERE  customer_id ='" . $row['cus_id'] . "'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row_cus = $result->fetch_assoc();

                            echo $row_cus['first_name'] . " " . $row_cus['last_name'];
                        } else {
                            echo $row['cus_name'];
                        }
                    } else {
                        echo $row['cus_name'];
                    }
                    ?>
                </td>                                
            </tr>
            <tr>
                <td>Telephone No </td>
                <td>
                    <?php
                    if ($row['cus_id'] != 0) {

                        echo $row_cus['contact_no'];
                    } else {
                        echo $row['tp_no'];
                    }
                    ?>
                </td>                                
            </tr>
            <tr>
                <td>Email Address </td>
                <td>
                    <?php
                    if ($row['cus_id'] != 0) {

                        echo $row_cus['email'];
                    } else {
                        echo $row['email'];
                    }
                    ?>
                </td>                                
            </tr>
            <?php
            if ($row['cus_id'] != 0) {
                ?>
                <tr>
                    <td>NIC No </td>
                    <td><?php echo $row_cus['nic']; ?> </td>                                
                </tr>
                <?php
            }
            ?>
            
                <?php
//                if ($result->num_rows > 0) {

                if ($row['order_status'] == "PRE") {
                   
                    ?>
                <tr>
                    <td>Current Status</td>
                    <td> Pre Order </td>
                </tr>
                <tr>
                    <td>Advance Payment Amount</td>
                    <td><?php
                        echo"Rs. ";
                        echo $amount = round(($row['production_cost'] - $row['discount']) / 2, 2);
                        ?> </td>
                </tr>

                <?php
                } elseif ($row['order_status'] == "FIN") {
                   
                    ?>
                   <tr>
                    <td>Current Status</td>
                    <td> Order Finish </td>
                </tr>
                <tr>
                    <td> Full Payment Amount (Due Amount ) </td>
                    <td>
                        <?php
                        echo"Rs. ";
                        echo $amount = round(($row['production_cost'] - $row['discount']) - $row['advance_payment'], 2);
                        ?></td>
                </tr>
                    <?php
                } elseif ($row['order_status'] == "PRO") {
                   
                    ?>
                <tr>
                    <td>Current Status</td>
                    <td> Order Processing </td>
                </tr>
                <tr>
                    <td>Additional Advance Payment
                        <br>
                        ( Maximum Amount : <?php
                        echo"Rs. ";
                        echo $amount = round(($row['production_cost'] - $row['discount']) - $row['advance_payment'], 2);
                        ?> ) </td>
                    <td>
                        
                        <input type="number" name="amount" class="form-control" id="amount" step=".01" placeholder="enter payment">
                        <input type="hidden" value="<?php echo $amount; ?>" name="max" id="max">
                         <div class="text-danger"><?php echo @$e['amount'];  ?></div>
                    </td>
                </tr>
                    <?php
                }
//                        }
                ?>
           

        <?php if ($row['order_status'] != "PRO") { ?>
            <input type="hidden" value="<?php echo $amount; ?>" name="amount" id="amount">
            <?php
        }
        ?>
            
        <input type="hidden" value="<?php echo $row['order_status']; ?>" name="stat" id="stat">
        </tbody>
    </table>
</div>
<?php
//        if ($row['order_status'] == "PRO") {
//            
?>
<!--            <div class="row">
                <div class="col"> 
                    <div class="form-group">
                        <label for="gender">Payment :</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> Rs. </span>
                                <input type="number" class="form-control" step=".01" id="payment" name="payment" placeholder="Enter Payment" value="//<?php ?>" >
                            </div>
                            <div class="text-danger">//<?php // echo @$e['payment'];  ?></div>
                        </div>
                    </div>
                </div>
            </div>-->
            <?php
//        }


        