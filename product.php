<?php include 'conn.php'; ?>
<?php include 'config.php'; ?>
<?php ?>
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
        <!--front family-->
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
                        <li class="nav-item dropdown active">

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
                        <li class="nav-item ">
                            <a class="nav-link" href="services.php">Services</a>

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
            <?php
//if individual product selected
            if ($_SERVER["REQUEST_METHOD"] == "GET" && @$_GET['product_id'] > 0) {
                $product_img = $product_name = $product_discription = null;
                $product_id = $_GET['product_id'];

                $sql_product = "SELECT * FROM `tb_product` WHERE product_id = '" . $_GET['product_id'] . "'";
                $result_product = $conn->query($sql_product);
                if ($result_product->num_rows > 0) {
                    while ($row = $result_product->fetch_assoc()) {
                        //assign data
                        $product_img = $row['product_img'];
                        $product_name = $row['name'];
                        $product_discription = $row['discription'];
                    }
                }
                ?>



                <!-- Heading Row -->

                <div class="row align-items-start my-5">

                    <div class="col-lg-7">

                        <h1 class="font-weight-light"><?php echo @$product_name; ?></h1>
                        <p><?php echo @$product_discription; ?></p>
                        <img src="<?php echo ROOT; ?>images/<?php echo @$product_img; ?>" class=" img-fluid rounded mx-auto d-block" alt="product" style="height: 400px">

                        <!-- Call to Action Well -->
                        <div>
                            <div class="card text-white bg-secondary my-2 py-4 text-center">
                                <div class="card-body">
                                    <div id="errorquate"></div>
                                    <p class="text-white m-0"></p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.col-lg-8 -->
                    <div class="col-lg-5">



                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-calculator " style="color:#7d1038" ></i>&nbsp; Instant quote</h3><p>Try our Price Calculator below</p>
                            </div>

                            <form id="quote_order_form">
                                <div class="card-body" id="result">
                                    <div class="form-group mb-2">
                                        <input type="hidden" name="pro_id" id="pro_id" value="<?php echo $product_id; ?>">  
                                    </div>
                                    <?php
                                     $sql = "SELECT tb_product_property.property_id, tb_product_property.property, tb_product_property.type 
                                            FROM tb_product_property_assign 
                                            LEFT JOIN tb_product_property ON tb_product_property.property_id=tb_product_property_assign.property_id 
                                            WHERE tb_product_property_assign.product_id = '$product_id'";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {

                                            $property[] = array($row['property'], $row['type'], $row['property_id']);
                                            // $type[] = $row['type'];
                                        }

                                        foreach ($property as $value) {
                                            //dynamicaly create name,id
                                            $field = strtolower(str_replace(" ", "_", $value[0]))."#".$value[2];
                                            ?><div class="form-group">                  

                                                <label for="<?php echo $field; ?>" style="color: #164A41" class="font-weight-bold" ><?php echo $value[0] . " :"; ?> </label>

                                                <?php
                                                 $sql_pro_val = "SELECT tb_product_property_value.`property_id`, tb_product_property_value.`value`,tb_product_property_value.property_value_id
                                                        FROM `tb_product_property_value` 
                                                        LEFT JOIN tb_product_property ON tb_product_property.property_id=tb_product_property_value.property_id 
                                                        WHERE tb_product_property_value.property_id = '$value[2]'";
                                                $result_pro_val = $conn->query($sql_pro_val);

                                                //form input type select as combo box
                                                if ($value[1] == "C") {
                                                    ?>
                                                    <select class="form-control select2" name="<?php echo $field; ?>" id="<?php echo $field; ?>" style="width: 100%;">
                                                        <option value="">Select value</option>
                                                        <?php
                                                        if ($result_pro_val->num_rows > 0) {
                                                            while ($row_pro_val = $result_pro_val->fetch_assoc()) {
                                                                ?>
                                                                <option value="<?php echo $row_pro_val['property_value_id']; ?>"<?php if (@$pro_val == $row_pro_val['value']) { ?> selected<?php } ?> > <?php echo $row_pro_val['value']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div id="error<?php echo $field; ?>"></div>
                                                    <?php
                                                }

                                                //form input type select as radio button
                                                if ($value[1] == "R") {
                                                    ?>
                                                    <div>
                                                        <?php
                                                        if ($result_pro_val->num_rows > 0) {
                                                            while ($row_pro_val = $result_pro_val->fetch_assoc()) {
                                                                ?>
                                                                <div class="form-check form-check-inline ml-3">
                                                                    <input class="form-check-input" type="radio" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="<?php echo $row_pro_val['property_value_id']; ?>" <?php if (@$Property_type == $row_pro_val['value']) { ?>checked <?php } ?>>
                                                                    <label class="form-check-label" for="<?php echo $field; ?>"><?php echo $row_pro_val['value']; ?></label>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    <div id="error<?php echo $field; ?>"></div>
                                                    <?php
                                                }

                                                //form input type select as number input
                                                if ($value[1] == "N") {
                                                    ?>
                                                    <div>
                                                    <input type="number" class="form-control" id="<?php echo $field; ?>" name="<?php echo $field; ?>" placeholder="Enter number" value="<?php echo $row_pro_val['value']; ?>">
                                                    </div>
                                                    <div id="error<?php echo $field; ?>"></div>
                <?php
            }
            ?>
                                            </div>
                                                <?php
                                            }
                                            $property = null;
                                        }
                                        ?>

                                    <div class="form-group">
                                        <label for="pro_qty" style="color: #164A41" class="font-weight-bold" >Product Qty :</label>
                                        <input type="number" class="form-control" id="pro_qty" name="pro_qty" placeholder="Enter qty of product">
                                        <div id="errorpro_qty"></div>
                                    </div>
                                    
                                </div>
                                <div class="card-footer ">
                                    <button type="button" class="btn btn-primary "  onclick="process_quate()">Calculate</button>
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="cus_name" style="color: #164A41" class="font-weight-bold">Name :</label>
                                        <input type="text" class="form-control" id="cus_name" name="cus_name" placeholder="Enter your name" value="<?php echo @$first_name; ?>">
                                        <div id="errorcus_name"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" style="color: #164A41" class="font-weight-bold">Email address :</label>
                                        <input type="text" name="email" id="email" class="form-control"  placeholder="Enter email" value="<?php echo @$email; ?>">
                                        <div id="erroremail"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="d_comment" style="color: #164A41" class="font-weight-bold" >Comment About Design  :</label>
                                        <textarea class="form-control" id="d_comment" name="d_comment" placeholder="Enter design what you want.."><?php echo @$design; ?></textarea>
                                        <div id="errord_comment"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="d_address" style="color: #164A41" class="font-weight-bold" >Delivery Address :</label>
                                        <textarea class="form-control" id="d_address" name="d_address" placeholder="Enter address"><?php echo @$address; ?></textarea>
                                        <div id="errord_address"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tp_no" style="color: #164A41" class="font-weight-bold">Telephone No :</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="tp_no" id="tp_no" placeholder="Enter telephone number" value="<?php echo @$tp_no; ?>">
                                        </div>
                                        <!-- /.input group -->
                                        <div id="errortp_no"></div>
                                    </div>
                                    <div id="errorresult"></div>
                                </div>
                                <!--/.card body-->

                                <div class="card-footer align-content-end">
                                    <!--<button type="button" class="btn btn-primary"  onclick="">Calculate</button>-->

                                    <button type="button" class="btn btn-primary"  onclick="order_register()">pre-order</button>
                                </div>

                            </form>


                        </div>


                    </div>
                    <!-- /.col-md-4 -->
                </div>
                <!-- /.row -->
                <div class="row">

                    <div class="col-lg-5 my-5">


                    </div>
                </div>
                <div class="" name="discount_product" id="discount_product">
                    <span class="text-center" >
                        <h3>You may also be interested in</h3>
                    </span>
                    <div class="titleboader"></div>
                </div>
                <!--Content Row--> 
                <div class="row">
                    <div class="col-md-3 mb-1">
                        <div class="card h-80">
                            <div class="card-body">
                                <h4 class="card-title text-center"><?php echo "Poster"; ?></h4>
                                <a href="product.php?product_id=<?php echo"3"; ?>">
                                    <img src="<?php echo ROOT; ?>images/122547176_2864797590414975_8303774429053626964_o.jpg" class=" img-fluid mx-auto d-block" alt="trending product" style="height: 180px" >
                                </a>
                            </div>
                            <div>
                                <p class="card-text"><?php // echo $row['discription'];     ?></p>
                            </div>

                        </div>
                    </div>
                    <!--/.col-md-4--> 
                    <div class="col-md-3 mb-1">
                        <div class="card h-80">
                            <div class="card-body">
                                <h4 class="card-title text-center"><?php echo "Business Card"; ?></h4>
                                <a href="product.php?product_id=<?php echo"11"; ?>">
                                    <img src="<?php echo ROOT; ?>images/60424_2966771_358371_image.jpg" class=" img-fluid mx-auto d-block" alt="trending product" style="height: 180px" >
                                </a>
                            </div>
                            <div>
                                <p class="card-text"><?php // echo $row['discription'];     ?></p>
                            </div>

                        </div>
                    </div>
                    <!--/.col-md-4--> 
                    <div class="col-md-3 mb-1">
                        <div class="card h-80">
                            <div class="card-body">
                                <h4 class="card-title text-center"><?php echo "Simple Book"; ?></h4>
                                <a href="product.php?product_id=<?php echo"2"; ?>">
                                    <img src="<?php echo ROOT; ?>images/xkmetbfb-a06580d6ef1d259cb1dcb4548d58bf84.jpg" class=" img-fluid mx-auto d-block" alt="trending product" style="height: 180px" >
                                </a>
                            </div>
                            <div>
                                <p class="card-text"><?php // echo $row['discription'];     ?></p>
                            </div>

                        </div>
                    </div>
                    <!--/.col-md-4--> 

                    <div class="col-md-3 mb-1">
                        <div class="card h-80">
                            <div class="card-body">
                                <h4 class="card-title text-center"><?php echo "Invitation"; ?></h4>
                                <a href="product.php?product_id=<?php echo"18"; ?>">
                                    <img src="<?php echo ROOT; ?>images/113242779_930027297502337_7235688851818760523_o.jpg" class=" img-fluid mx-auto d-block" alt="trending product" style="height: 180px" >
                                </a>
                            </div>
                            <div>
                                <p class="card-text"> <?php // echo $row['discription'];     ?></p>
                            </div>

                        </div>
                    </div>
                    <!--/.col-md-4--> 
                </div>
                <!--/.row--> 
    <?php
}





//if all product slected
if ($_SERVER["REQUEST_METHOD"] == "GET" && @$_GET['product_id'] == 0) {
    ?>
                <div class="my-3 bg-transparent mt-5">

                    <div class="" name="trending_product" id="trending_product">
                        <span class="text-center" >
                            <h3>All Products</h3>
                        </span>
                        <div class="titleboader"></div>
                    </div>
                </div>
                <!-- Content Row -->
                <div class="row card-group" >
    <?php
    $sql_product = "SELECT * FROM `tb_product` ORDER BY `tb_product`.`name` ASC";
    $result_product = $conn->query($sql_product);
    if ($result_product->num_rows > 0) {
        while ($row = $result_product->fetch_assoc()) {
            ?>

                            <div class="col-md-3 mb-5">
                                <a href="product.php?product_id=<?php echo $row['product_id']; ?>">
                                    <div class="card h-80">
                                        <div class="card-body">

                                            <h4 class="card-title"><?php echo $row['name']; ?></h4>

                                            <img src="<?php echo ROOT; ?>images/<?php echo $row['product_img']; ?>" class=" img-fluid" alt="trending product" style="height: 150px">
                                        </div>
                                        <div>
                                            <p class="card-text"><?php //  echo $row['discription'];                     ?></p>
                                        </div>

                                    </div>
                                </a>

                            </div>

            <?php
        }
    }
    ?>
                    <!-- /.col-md-4 -->

                </div>
                <!-- /.row -->
    <?php
}
?>

            <!--single product-->
        </div>
        <!-- /.container -->

        <!-- Footer -->
        <footer class="py-4 bg-dark">
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

<script type="text/javascript">
                                    function order_register() {
                                        var mydata = $("#quote_order_form").serialize();
//   alert(mydata);
                                        $.ajax({
                                            type: 'POST',
                                            
                                            data: mydata,
                                            url: "order_process.php",

                                            success: function (data) {

//alert(data);

//alert(data.paper_size);

//                                                for (const[key, value] of Object.entries(data)) {
////            alert(value);
//                                                    $("#error" + key).html(value);
//                                                }
//$("#errorpaper_size").html(data.paper_size);
//$("#errorpaper_thick").html(data.paper_thick);
$("#errorquate").html(data);
                                            },
                                            error: function (request, status, error) {
//                                                alert(request.responseText);
                                            }
                                        });
                                    }

                                    function process_quate() {
                                        var mydata = $("#quote_order_form").serialize();
//   alert(mydata);
                                        $.ajax({
                                            type: 'POST',
                                            
                                            data: mydata,
                                            url: "quate_process.php",
                                            success: function (data) {
//alert(data);
//                                                for (const[key, value] of Object.entries(data)) {
////            alert(value);
//                                                    $("#error" + key).html(value);
//                                                    $('html, body').animate({
//                                                        scrollTop: $("#error" + key).offset().top - 20 //#DIV_ID is an example. Use the id of your destination on the page
//                                                    }, 'slow');
//
//                                                }
                                                $("#errorquate").html(data);

                                            },
                                            error: function (request, status, error) {
//                                                alert(request.responseText);
                                            }
                                        });
                                    }

</script>