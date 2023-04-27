<?php include 'conn.php'; ?>
<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>e-Printing Shop - Services</title>
        <link rel = "icon" type = "image/png" href = "images/20638569_259745781197162_4269375431305161305_n.png">
        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/mywebstyle.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
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
                        <li class="nav-item">
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

                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="services.php">Services</a>
                            <span class="sr-only">(current)</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login/Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container">

            <!-- Heading Row -->
            <div class="row align-items-center my-5">
                <div class="col-lg-7">
                    <img class="img-fluid rounded mb-4 mb-lg-0" src="http://placehold.it/900x400" alt="">
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-5">
                    <h1 class="font-weight-light">Business Name or Tagline</h1>
                    <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
                    <a class="btn btn-primary" href="#">Call to Action!</a>
                </div>
                <!-- /.col-md-4 -->
            </div>
            <!-- /.row -->

            <!-- Call to Action Well -->
            <div class="card text-white bg-secondary my-5 py-4 text-center">
                <div class="card-body">
                    <p class="text-white m-0">This call to action card is a great place to showcase some important information or display a clever tagline!</p>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <img class="img-fluid rounded mb-4 mb-lg-0" src="images/20748304_261164157721991_8603642212216157868_o.jpg" alt="">

                    </div>
                </div>
                <!-- /.col-md-4 -->
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <img class="img-fluid rounded mb-4 mb-lg-0" src="images/71397347_696241364214266_293151300571365376_n.jpg" alt="">
                        </div>
                        
                    </div>
                </div>
                <!-- /.col-md-4 -->
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title">Card Three</h2>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.</p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-primary btn-sm">More Info</a>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-4 -->

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

        <!-- Footer -->
        <footer class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; Your Website 2020</p>
            </div>
            <!-- /.container -->
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
