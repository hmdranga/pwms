 <?php
 include '../conn.php';
                $sql = "SELECT * FROM tb_divsecretariat WHERE Dis_Code='".$_POST['dis_code']."'";
                $result = $conn->query($sql);
                ?>
                <label>Divisional Secretariatejhbhjbjkk</label>
                <select class="form-control" id="divsecretariat" name="divsecretariat" >
                    <option value="">--Select a District--</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row=$result->fetch_assoc()){
                        ?>
                        <option value="<?php echo $row['DivSecretariat'] ?>"><?php echo $row['DivSecretariat'] ?></option>
                        <?php
                        }
                    }
                    ?>
                </select>