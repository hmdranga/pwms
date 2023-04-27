<?php
session_start();
include 'conn.php';
include 'helper.php';
include 'config.php';
//Check Page Request Method
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Define variables
    $user_name = $password = null;
    //define arry for display error messages
    $e = array();
    //Assign Data--------------------------------------
    $user_name = clean_input($_POST['user_name']);
    $password = clean_input($_POST['password']);
    //End assign data----------------------------------
    //Check input fields are empty---------------------
    if (empty($user_name)) {
        $e['user_name'] = "Username should not be empty..!";
    }
    if (empty($password)) {
        $e['password'] = "Password should not be empty..!";
    }
    //End check input fields are empty-----------------
    
    if (empty($e)) {
        //select user if available
        $sql = "SELECT*FROM tb_user WHERE user_name='$user_name' AND password='" . sha1($password) . "'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['profile_image'] = $row['profile_image'];
            }
            header('Location:dashboard.php');
        } else {
            $e['invalid'] = "Username or Password invalid..!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>pwms</title>
        <link rel = "icon" type = "image/png" href = "<?php echo ROOT; ?>images/20638569_259745781197162_4269375431305161305_n.png">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/mywebstyle.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/mywebstyle.css" rel="stylesheet">
        <!--google front family-->
        <link href='https://fonts.googleapis.com/css?family=Rosario' rel='stylesheet'>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark my-nav-bg fixed-top">
            <div class="container">
                <div >
                    <a class="navbar-brand" href="index.php"><img src="<?php echo ROOT; ?>images/20638569_259745781197162_4269375431305161305_n.png" class="img-thumbnail rounded " style="width:60px"></a>

                </div>

                <div>
                    <a class="navbar-brand" href="index.php">&nbsp;<span style="color: blue">S</span><span style="color:yellow">m</span><span style="color: red">a</span><span style="color: green">r</span><span style="color:blueviolet ">t</span> Way To Print...<span style="color: #7d1038">..</span><i class="fas fa-paint-brush " style="color:#7d1038" ></i></a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item ">
                            <a class="nav-link" href="index.php">Home

                            </a>
                        </li>
                        <li class="nav-item dropdown">

                            <a class="nav-link"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="#">
                                <span style="color: #164A41"><i class="right fas fa-caret-square-down"></i>
                                    Product
                                </span>
                            </a>
                            <?php
                            $sql_sub = "SELECT `product_id`, `name` FROM `tb_product`";
                            $result_sub = $conn->query($sql_sub);
                            ?>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #7A9D96;">

                                <ul class="nav">
                                    <li class="nav-item dropdown-item">
                                        <a class="nav-link" style="color: #ffffff" href="product.php">All Products</a>
                                    </li>
                                    <?php
                                    if ($result_sub->num_rows > 0) {
                                        while ($row_sub = $result_sub->fetch_assoc()) {
                                            ?>
                                            <li class="nav-item dropdown-item">
                                                <a class="nav-link" style="color: #ffffff" href="product.php?product_id=<?php echo $row_sub['product_id']; ?>">

                                                    <?php echo $row_sub['name'];
                                                    ?>

                                                </a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="about.php">About</a>

                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="login.php">Login</a>
                            <span class="sr-only">(current)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page Content -->
        <div class="container">


            <div class="row">
                <div class="col-lg my-5">
                    <div class="mb-5">
                        <div class="card h-100">
                            



















                                                  
                        </div>
                    </div>

                </div>
                <div class="col-lg">
                    <div class="mb-5 my-5">
                        <div class="card h-100">
                            <div class="card-header">

                                <div class="row login-logo align-items-center ">
                                    <div>
                                        <img src="<?php echo ROOT; ?>images/20638569_259745781197162_4269375431305161305_n.png" class="img-thumbnail rounded " style="width:100px;">
                                    </div>
                                    <div>
                                        <h2 class="card-title" >&nbsp; Member Login</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">



                                <!--login-page-->
                                <div class="hold-transition login-page">
                                    <div class="login-box">
                                        <!-- /.login-logo -->

                                        <div class="card-body login-card-body">
                                            <p class="login-box-msg">Have an account?</p>

                                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="Enter User Name" name="user_name" id="user_name">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-user"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-danger"><?php echo @$e['user_name']; ?></div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-lock"></span>
                                                            </div>
                                                        </div>  
                                                    </div>
                                                    <div class="text-danger"><?php echo @$e['password']; ?></div>
                                                    <div class="text-danger"><?php echo @$e['invalid']; ?></div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <div class="icheck-primary">
                                                            <!--<input type="checkbox" id="remember">-->
<!--                                                            <label for="remember">
                                                                Remember Me
                                                            </label>-->
                                                            <div>
                                                                <!--<a href="#">Forgot password?</a>-->
                                                        </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col-4">
                                                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                            </form>  

                                            <!-- /.login-card-body -->
                                        </div>
                                    </div>
                                    <!-- /.login-box -->
                                </div>
                                <!-- /.login-page -->   















                            </div>                       
                        </div>
                    </div>

                </div>

            </div>


        </div>
        <!-- /.container -->
        <!-- Footer -->
        <footer class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; D-Ads Digital 2020</p>
            </div>
            <!-- /.container -->
        </footer>
        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
