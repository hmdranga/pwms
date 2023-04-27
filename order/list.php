<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "view") {
    $order_id = $product_name = $coment = $cus_name = $d_address = $tp_no = $date = $discount= $email = $advance  = $qty  = null;
    $product_name = $_POST['product'];
    $order_id = $_POST['order_id'];

    $sql = "SELECT * FROM `tb_order` WHERE order_id = $order_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $coment = $row['comment'];
           
            $qty = $row['qty'];
            $cus_name = $row['cus_name'];
            $d_address = $row['d_address'];
             $email = $row['email'];
            $tp_no = $row['tp_no'];
            $date = $row['date'];
            $discount = $row['discount'];
             $advance = $row['advance_payment'];
              $pro_cost = $row['production_cost'];
               $status = $row['order_status'];
            
        }
    }
}
?>
<table class="table table-hover table-responsive-md table-striped ">
    <tr>
        <td style="width:20%">Order Id :</td>
        <td><?php echo $order_id; ?></td>
    </tr>
    
    <tr>
        <td>Product :</td>
        <td><?php echo $product_name; ?></td>
    </tr>

    <tr>
        <td>Qty :</td>
        <td><?php
            echo $qty; 
            ?>
        </td>
    </tr>
    <tr>
        <td>Comment :</td>
        <td><?php
            echo $coment; 
            ?>
        </td>
    </tr>
    <tr>
        <td>Customer :</td>
        <td><?php
            echo $cus_name; 
            ?>
        </td>
    </tr>
    <tr>
        <td>Telephone :</td>
        <td><?php
            echo $tp_no; 
            ?>
        </td>
    </tr>
    <tr>
        <td>email :</td>
        <td><?php
            echo $email; 
            ?>
        </td>
    </tr>
    <tr>
        <td>Discount :</td>
        <td><?php
            echo $discount;
            
            ?></td>
    </tr>
    <tr>
        <td>Advance :</td>
        <td><?php
            echo $advance;
            
            ?></td>
    </tr>
    <tr>
        <td>Grand Total :</td>
        <td><?php
            echo $pro_cost;
            
            ?></td>
    </tr>

</table>