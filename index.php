<?php include 'conn.php'; ?>
<?php include 'config.php'; ?>
<?php
//companay information view
$logo = $description = $cm_mn = null;
$sql_homepg_info = "SELECT * FROM `tb_homepg_info`";
$result_view_home = $conn->query($sql_homepg_info);
if ($result_view_home->num_rows > 0) {
    $row = $result_view_home->fetch_assoc();
    $com_nm = $row['name'];
    $description = $row['description'];
    $logo = $row['logo'];
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>e-Printing Shop</title>
        <link rel = "icon" type = "image/png" href = "images/20638569_259745781197162_4269375431305161305_n.png">
        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/mywebstyle.css" rel="stylesheet">
        <!-- Font awesome icons -->
        <link rel="stylesheet" href="<?php echo ROOT; ?>plugins/fontawesome-free/css/all.min.css" >
        <!--google front family-->
        <link href='https://fonts.googleapis.com/css?family=Rosario' rel='stylesheet'>
    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark my-nav-bg fixed-top">

            <div class="container">

                <div >
                    <a class="navbar-brand" href="index.php"><img src="<?php echo ROOT; ?>images/<?php echo $logo; //20638569_259745781197162_4269375431305161305_n.png      ?>" class="img-thumbnail rounded " style="width:60px"></a>

                </div>

                <div>
                    <a class="navbar-brand" href="">&nbsp;<span style="color: #0D19A3">S</span><span style="color:#FFE400">m</span><span style="color: #BC4639">a</span><span style="color: #0677A1">r</span><span style="color:#802BB1 ">t</span> Way To Print...<span style="color:#164A41">..<i class="fas fa-paint-brush "  ></i></span></a>
                </div>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Home
                                <span class="sr-only">(current)</span>
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
                                        <a class="nav-link" style="color: #ffffff" href="product.php?product_id=0">All Products</a>
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

                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
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
            <div class="row ">

                <div class="col-lg-7  my-5">

                    <div id="demo" class="carousel slide" data-ride="carousel">

                        <!-- Indicators -->
                        <ul class="carousel-indicators">
                            <?php
                            $sql_slide = "SELECT * FROM `tb_slideshow_homepg`";
                            $result_slide = $conn->query($sql_slide);
                            if ($result_slide->num_rows > 0) {
                                $x = 0;
                                $sld_img_info = array();
                                while ($row_slide = $result_slide->fetch_assoc()) {

                                    array_push($sld_img_info, $row_slide['active'] . $row_slide['img']);
                                    ?>
                                    <li data-target="#demo" data-slide-to="<?php echo $x; ?>" <?php if ($row_slide['active'] == 1) { ?>class="active"<?php } ?> ></li>

                                    <?php
                                    $x++;
                                }
                                ?>
                            </ul>

                            <!-- The slideshow -->
                            <div class="carousel-inner ">
                                <?php
                                foreach ($sld_img_info as $data) {
                                    ?>
                                    <div class="carousel-item  <?php if (substr($data, 0, 1) == 1) { ?> active <?php } ?>">
                                                <!--<img src="images/smartprint.jpg"  width="1100" height="500">-->
                                        <img src="images/web_slide/<?php echo substr($data, 1); ?>" alt="company logo" width="1100" height="500">
                                    </div>

                                    <?php
                                }
                            }
                            ?>

                        </div>
                        <!-- Left and right controls -->
                        <a class="carousel-control-prev" href="#demo" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#demo" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                    <!--                    <div id="product_des" name="product_des">
                                        </div>-->
                </div>
                <!-- /.col-lg-7 -->

                <div class="col-lg-5 my-5">
                    <!-- Call to Action Well -->
                    <div class="card text-white bg-secondary py-2 text-center">
                        <div class="card-body">
                            <h3 class="font-weight-light"><?php echo $com_nm; ?></h3>
                            <div class="titleboader"></div>
                            <p class="m-0"><?php echo $description; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="card ">
                <div class="card-header align-content-center">


                    <form role="form" method="GET" action="product.php">
                        <div class="row">
                            <div class="col-sm">
                                <h3 class="card-title"><i class="fas fa-calculator " style="color:#7d1038" ></i>&nbsp; Instant Quote </h3>

                            </div>
                            <div class="col-sm">

                                <!--<div class="card-body">-->
                                <div class="form-group mb-2"">
                                    <?php
                                    $sql_product = "SELECT  `product_id`,`name`FROM `tb_product`";
                                    $result_product = $conn->query($sql_product);
                                    ?>
                                    <!--<label for="product"><h5>Product</h5></label>-->
                                    <select class="form-control select2" name="product_id" id="product_id" style="width: 100%;">
                                        <option value="">Select existing Product</option>
                                        <?php
                                        if ($result_product->num_rows > 0) {
                                            while ($row_product = $result_product->fetch_assoc()) {
                                                ?>

                                                <option value="<?php echo $row_product['product_id']; ?>"<?php if (@$product_id == $row_product['product_id']) { ?> selected<?php } ?> > <?php echo $row_product['name']; ?></option>

                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>

                                </div>
                                <!--</div>-->
                            </div>
                            <div class="col-sm">
                                <!--   <div class="content-wrapper">-->
                                <button type="submit" class="btn btn-primary btn-lg rounded-bottom float-right" >Next <i class="fas fa-angle-right"></i></button>
                                <!--</div>-->
                            </div>
                        </div>
                    </form>


                </div>


            </div>

            <div class="my-3 bg-transparent">
                <div class="" name="trending_product" id="trending_product">
                    <span class="text-center" >
                        <h3>Trending Products</h3>
                    </span>
                    <div class="titleboader"></div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row card-group" >
                <?php
                $sql_trending = "SELECT tb_product_trending.product_id, tb_product.name, tb_product.product_img, tb_product.discription FROM `tb_product_trending`LEFT JOIN tb_product ON tb_product.product_id=tb_product_trending.product_id";
                $result_trending = $conn->query($sql_trending);
                if ($result_trending->num_rows > 0) {
                    while ($row = $result_trending->fetch_assoc()) {
                        ?>
                        <div class="col-md-3 mb-1">
                            <div class="card h-80">
                                <div class="card-body">
                                    <h4 class="card-title text-center"><?php echo $row['name']; ?></h4>
                                    <a href="product.php?product_id=<?php echo $row['product_id']; ?>">
                                        <img src="<?php echo ROOT; ?>images/<?php echo $row['product_img']; ?>" class=" img-fluid mx-auto d-block" alt="trending product" style="height: 180px" >
                                    </a>
                                </div>
                                <div>
                                    <p class="card-text"><?php // echo $row['discription'];           ?></p>
                                </div>

                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                <!-- /.col-md-4 -->

            </div>
            <!-- /.row -->

            <div class="" name="discount_product" id="discount_product">
                <span class="text-center" >
                    <h3>Special Offers</h3>
                </span>
                <div class="titleboader"></div>
            </div>           

            <!-- Content Row -->
            <div class="row card-group">
                <?php
                $sql_discount = "SELECT tb_product_discount.product_id, tb_product.name, tb_product.product_img, tb_product_discount.discount FROM `tb_product_discount`LEFT JOIN tb_product ON tb_product.product_id=tb_product_discount.product_id";
                $result_discount = $conn->query($sql_discount);
                if ($result_trending->num_rows > 0) {
                    while ($row = $result_discount->fetch_assoc()) {
                        ?>
                        <div class="col-md-3 mb-1">
                            <div class="card h-80" >
                                <div class="card-body" >
                                    <div id="discount_product">
                                        <h4 class="card-title"><?php echo $row['name']; ?></h4>
                                        <a href="product.php?product_id=<?php echo $row['product_id']; ?>">
                                            <img src="<?php echo ROOT; ?>images/<?php echo $row['product_img']; ?>" class="card-img-top rounded img-fluid" alt="trending product" hight="200px">

                                            <div class="discount">

                                                <span style="color: #FAED26;"><h1><?php echo $row['discount'] . "% off"; ?></h1></span>
                                            </div>

                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
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
    <script type="text/javascript">
    </script>
</html>

