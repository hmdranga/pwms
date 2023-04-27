<?php
include '../conn.php';
$sql = "SELECT tb_supplier.supplier_id, tb_supplier.`com_nm` FROM tb_supplier_tool_group
                                LEFT JOIN tb_supplier ON tb_supplier_tool_group.supplier_id=tb_supplier.supplier_id
                                WHERE tb_supplier_tool_group.group_code = " . $_POST['load_type'];
$result = $conn->query($sql);
?>
<label for="supplier">Supplier :</label>
<select class="form-control select2" name="supplier" id="supplier" style="width: 100%;">
    <option value="">Select existing Supplier</option>
    <?php
    while ($row_sup = $result->fetch_assoc()) {
        ?>
        <option value="<?php echo $row_sup['supplier_id']; ?>"<?php if (@$sup_id == $row_sup['supplier_id']) { ?> selected<?php } ?> > <?php echo $row_sup['com_nm']; ?></option>
        <?php
    }
    ?>
</select>

