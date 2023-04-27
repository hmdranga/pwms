
<?php include 'conn.php'; ?>
<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>e-Printing Shop - Contact</title>

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
                            <a class="nav-link" href="contact.php">Contact</a>
                            <span class="sr-only">(current)</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
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
                    <img class="img-fluid rounded mb-4 mb-lg-0" src="images/dads.PNG" alt="">
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-5">
                    <h1 class="font-weight-light">The D Ads Digital </h1>
                    <p>NO: 10/B,  </p>
                    <p>Sri Somananda Mawatha, </p>
                    <p>Horana.</p>
                    <div>Tel : 071-0493860</div>
                    <p></p>
                    <p>
                    sales.dadsdigital@gmail.com</p>
                </div>
                <!-- /.col-md-4 -->
            </div>
            <!-- /.row -->

            <!-- Call to Action Well -->
          

            <!-- Content Row -->
            <div class="row">

                <!-- /.col-md-4 -->
               
                <!-- /.col-md-4 -->
                
                <!-- /.col-md-4 -->

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

        <!-- Footer -->
        <footer class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright © D-Ads Digital 2021. All rights reserved.</p>
            </div>
            <!-- /.container -->
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
