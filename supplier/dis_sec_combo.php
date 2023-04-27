<?php
include '../conn.php';
$sql = "SELECT * FROM tb_divsecretariat WHERE Dis_Code='" . $_POST['dis_code'] . "'";
$result = $conn->query($sql);
?>
<label>Divisional Secretariat</label>
<select class="form-control" id="divsecretariat" name="divsecretariat" >
    <option value="">--Select a District--</option>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <option value="<?php echo $row['DivSec_Code'] ?>"><?php echo $row['DivSecretariat'] ?></option>
            <?php
        }
    }
    ?>
</select>