<?php
include '../conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT pp.property_id, pp.property
        FROM tb_accessory_type_property atp
        LEFT JOIN tb_product_property pp ON pp.property_id = atp.property_id 
        WHERE atp.accessory_type_id = '" . $_POST['type_id'] . "'";
    $result = $conn->query($sql);
    ?>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            
                ?>
                <div class="form-group">
                    <label for="<?php echo strtolower(str_replace(" ", "_", $row['property'])); ?>"><?php echo $row['property']; ?> :</label>
                    <?php
                    $sql_pro_val = "SELECT * FROM `tb_product_property_value` LEFT JOIN tb_product_property ON tb_product_property.property_id=tb_product_property_value.property_id WHERE tb_product_property_value.property_id = '" . $row['property_id'] . "'";
                    $result_pro_val = $conn->query($sql_pro_val);
                    ?>
                    <select class="form-control" id="<?php echo strtolower(str_replace(" ", "_", $row['property'])); ?>" name="<?php echo strtolower(str_replace(" ", "_", $row['property'])); ?>" >
                        <option value="">--Select a Value--</option>
                        <?php
                        if ($result_pro_val->num_rows > 0) {
                            while ($row_pro_val = $result_pro_val->fetch_assoc()) {
//                        $property_value = $row_pro_val['value'];
                                ?>
                                <option value="<?php echo $row_pro_val['property_value_id']; ?>"<?php if (@$pro_val_id == $row_pro_val['property_value_id']) { ?> selected<?php } ?> > <?php echo $row_pro_val['value']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>


                <?php
            }
        }
}
    
?>