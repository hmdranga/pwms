<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php

//sql for list table
$sql_view = "SELECT YEAR(date) as year, monthname(date) as month ,SUM(amount) as amount FROM `tb_payment` GROUP BY YEAR(date), month(date)";
$result_view = $conn->query($sql_view);
?>
<div class="card-header">

        <div class="row">
            <div class="col">
                <h3 class="card-title"><i class="fas fa-users"></i> Monthly revenue </h3>
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
                        <th>Year</th>
                        <th>Month</th>
                        <th>amount</th>
               
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_view->num_rows > 0) {
                        while ($row = $result_view->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['year']; ?></td>
                                
                                <td><?php echo $row['month']; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                               
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
