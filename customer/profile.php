<!--page name : create user
Created 25.08.2020 -->
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php

if ($_SERVER['REQUEST_METHOD']=='POST'){
    $first_name= $last_name= $user_name= $password = null;
    $e=array();
    

//Assign data--------------------------------------------
$first_name = clean_input($_POST['first_name']);
$last_name = clean_input($_POST['last_name']);
$user_name = clean_input($_POST['user_name']);
$password = clean_input($_POST['password']);
//End assign data---------------------------------------
//Check input fields are empty-------------------------

if (empty($first_name)){
    $e['first_name']= "First Name sould not be empty.." ;
}else{
       if (!preg_match("/^[a-zA-Z ]*$/", $first_name)){
           $e['first_name']='Invalid first name';
       }
}
if (empty($last_name)){
    $e['last_name']= "Last Name should not be empty..";
}else{
       if (!preg_match("/^[a-zA-Z ]*$/", $last_name)){
           $e['last_name']='Invalid last name';
       }
}
if (empty($user_name)){
    $e['user_name']= "User Name sould not be empty..";
}else{
       if (!preg_match("/^[a-zA-Z ]*$/", $user_name)){
           $e['user_name']='Invalid user name';
       }
}
if (empty($password)){
    $e['password']="Password should not be empty..";
}
}

?>
 <div class="container-fluid">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Create User</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"novalidate>

                <div class="card-body">
                    <div class="form-group">
                        <label for="first_name">First Name :</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" value="<?php echo @$first_name; ?>">
                        <div class="text-danger"><?php echo @$e['first_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name :</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name"value="<?php echo @$last_name; ?>">
                        <div class="text-danger"><?php echo @$e['last_name']; ?></div>
                    </div>
                  
                    <div class="form-group">
                        <label for="usr_name">User Name :</label>
                        <input type="user_name" class="form-control" id="user_name" name="user_name" placeholder="Enter user name" value="<?php echo @$user_name; ?>">
                        <div class="text-danger"><?php echo @$e['user_name']; ?></div>
                    </div>

                  <div class="form-group">
                        <label for="password">Password :</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                        <div class="text-danger"><?php echo @$e['password']; ?></div>
                    </div>


               <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    
<?php include '../footer.php'; ?>

