<?php

include '../conn.php';
$sql = "SELECT * FROM `tb_skill` WHERE  desig_id ='" . $_POST['desig_id'] . "'";
$result = $conn->query($sql);
?>
<label for="skill">Skill :</label>
<?php
if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $row['skill_id']; ?>" id="<?php echo $row['skill_id']; ?>" name="skill[]" <?php
                        if (!empty($skill)) {
                            if (in_array($row['skill_id'], @$skill)) {
                                        ?>checked<?php
                                               }
                                           }
                                           ?> >
                                    <label class="form-check-label" for="<?php echo $row['skill_id']; ?>">
                                        <?php echo $row['skill'] ?>
                                    </label>
                                </div>
                                <?php
                            }
                        }
                        ?>      