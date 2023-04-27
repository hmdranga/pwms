
 <div class="form-group">
                    <label for="address">Address :</label>
                    <textarea class="form-control" id="address" name="address" placeholder="Enter address"><?php echo @$address; ?></textarea>
                    <div class="text-danger"><?php echo @$e['address']; ?></div>
                </div>
                <!-- phone mask -->
                <div class="form-group">
                    <label for="tp_no">Telephone No :</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" class="form-control" name="tp_no" id="tp_no" placeholder="Enter telephone number" value="<?php echo @$tp_no; ?>">
                    </div>
                    <!-- /.input group -->
                    <div class="text-danger"><?php echo @$e['tp_no']; ?></div>
                </div>
                <div class="form-group">
                    <label for="email">Email address :</label>
                    <input type="text" name="email" id="email" class="form-control"  placeholder="Enter email" value="<?php echo @$email; ?>">
                    <div class="text-danger"><?php echo @$e['email']; ?></div>
                </div>


                <div class="form-group">
                    <label for="gender">Gender :</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="M" <?php if (@$gender == "M") { ?>checked <?php } ?>>
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="F"<?php if (@$gender == "F") { ?>checked <?php } ?>>
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                    </div>
                    <div class="text-danger"><?php echo @$e['gender']; ?></div>
                </div>

                <div class="form-group">
                    <label for="nic">NIC NO :</label>
                    <input type="text" class="form-control" id="nic" name="nic" placeholder="Enter nic no" value="<?php echo @$nic; ?>">
                    <div class="text-danger"><?php echo @$e['nic']; ?></div>
                </div>

                <div class="form-group">
                    <label for="skills">Skills :</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="graphic_design" id="graphic_design" name="skill[]" <?php
                        if (isset($_POST['skill'])) {
                            if (in_array("graphic_design", @$skill)) {
                                ?>checked <?php
                                   }
                               }
                               ?>>
                        <label class="form-check-label" for="graphic_design">
                            Graphic Designing
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="typing" id="typing" name="skill[]"<?php
                        if (isset($_POST['skill'])) {
                            if (in_array("typing", @$skill)) {
                                ?>checked <?php
                                   }
                               }
                               ?>>
                        <label class="form-check-label" for="typing">
                            Typing
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="operating" id="operating" name="skill[]"<?php
                        if (isset($_POST['skill'])) {
                            if (in_array("operating", @$skill)) {
                                ?>checked <?php
                                   }
                               }
                               ?>>
                        <label class="form-check-label" for="operating">
                            Operating
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="management" id="management" name="skill[]"<?php
                        if (isset($_POST['skill'])) {
                            if (in_array("management", @$skill)) {
                                ?>checked <?php
                                   }
                               }
                               ?>>
                        <label class="form-check-label" for="Management">
                            Management
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="accounting" id="accounting" name="skill[]"<?php
                        if (isset($_POST['skill'])) {
                            if (in_array("accounting", @$skill)) {
                                ?>checked <?php
                                   }
                               }
                               ?>>
                        <label class="form-check-label" for="accounting">
                            Accounting
                        </label>
                    </div>
                    <div class="text-danger"><?php echo @$e['skill']; ?></div>
                </div>
                <div class="form-group">
                    <label for="nic">CV :</label>
                    <div>
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            Select image to upload:
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input type="submit" value="Upload Image" name="submit">
                        </form>
                    </div>
                    <div class="text-danger"><?php echo @$e['nic']; ?></div>
                </div>

                
                
                
                
                
                <div class="row">
                    <div class="col"></div>
<div class="col"></div>

                    
                </div>
                
                
                
     <?php           
                if (!empty($password)) {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialchars = preg_match('@[^\w]@', $password);
        if ($uppercase AND $lowercase AND $number AND $specialchars == 0 || strlen($password) < 8) {
            $e['password'] = 'Password should be at least 8 characters & Should include at least one uppercase letter, One number, and One special character';
        }
    }