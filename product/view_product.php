<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "view_product") {
    $product_id = $product_name = $description = $product_image = $task = null;
    $product_id = $_POST['product_id'];

    $sql = "SELECT * FROM `tb_product` WHERE product_id = $product_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_name = $row['name'];
            $description = $row['discription'];
            $product_image = $row['product_img'];
        }
    }
}
?>
<div class="row">
    &nbsp;  
    <a  href="register.php"><button type="button" class="btn btn-group-lg" onmouseover="this.style.color = '#83a95c'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-arrow-alt-circle-left fa-lg" ></i></button></a>               
    <form method="post" action="register.php">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <button type="submit" name="operate" value="edit_product" class="btn btn-group-lg" onmouseover="this.style.color = '#ff8000'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-edit" ></i></button>                   
    </form>
    <form method="post" action="delete_product.php">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <input type="hidden" name="product_image" value="<?php echo $product_image; ?>">
        <button type="submit" name="operate" value="delete" class="btn btn-group-lg" onmouseover="this.style.color = '#ff1a1a'" onmouseout="this.style.color = '#383f45'"><i class="fas fa-trash-alt" ></i></button>         
    </form>
</div>
<table class="table table-bordered bg-gray-dark table-striped">
    <tr>
        <td style="width:20%">Product Name :</td>
        <td><?php echo $product_name; ?></td>
    </tr>
    <tr>
        <td>Image :</td>
        <td><img src="<?php echo ROOT; ?>images/<?php echo $product_image; ?>" alt="product_image" class=" img-rounded" style="opacity: .9" width="200" height="180"></td>
    </tr>
    <tr>
        <td>Description :</td>
        <td><?php echo $description; ?></td>
    </tr>

    <tr>
        <td>Assigned Tasks :</td>
        <td><?php
            $sql = "SELECT tb_task.name as task_name FROM tb_product_task LEFT JOIN tb_task ON tb_task.task_id=tb_product_task.task_id WHERE tb_product_task.product_id = " . $product_id . "";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $task[] = $row['task_name'];
                }

                foreach ($task as $value) {

                    echo $value . ",";
                    echo "<br>";
                }

                $task = null;
            } else {
                echo "--";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>Discount :</td>
        <td><?php
            $sql = "SELECT `discount` FROM `tb_product_discount` WHERE product_id = $product_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo $row['discount'] . "%";
            } else {
                echo "--";
            }
            ?></td>
    </tr>
    <tr>
        <td>Is in trending list :</td>
        <td><?php 
               $sql = "SELECT  `product_id` FROM `tb_product_trending` WHERE product_id = $product_id";
               $result = $conn-> query($sql);
                if ($result->num_rows > 0) {
                    echo "Yes";
                } else {
                    echo "No";     
}
        ?></td>
    </tr>

</table>