<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php

//sql for list table
$sql_view = "SELECT product_id , COUNT(order_id) as oder_count  FROM `tb_order` GROUP by product_id";
$result_view = $conn->query($sql_view);
?>
<div class="card-header">

        <div class="row">
            <div class="col">
                <h3 class="card-title"><i class="fas fa-users"></i> Order Count By Product </h3>
            </div>
            <div class="col">
                <?php
                echo" count: " . $result_view->num_rows;
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
                        <th>product</th>
                        <th>Order Count</th>
                        
               
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_view->num_rows > 0) {
                        while ($row = $result_view->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php 
                                $sql = "SELECT name  FROM tb_product where  product_id = ".$row['product_id'];
                                          $result = $conn->query($sql);
                                            $row_a = $result->fetch_assoc();
                                           echo $row_a['name'];
                               ?></td>
                                
                                <td><?php echo $row['oder_count']; ?></td>
                               
                               
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
