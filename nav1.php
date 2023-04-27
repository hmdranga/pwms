<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?php echo ROOT; ?>index.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="dist/img/avatar5.png" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo ROOT;?>logout.php" role="button">Logout</a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo ROOT; ?>index.php" class="brand-link">
        <img src="<?php echo ROOT; ?>images/logo1.jpg" alt="company logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">The D Ads Digital</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo ROOT; ?>images/<?php echo $_SESSION['profile_image'];?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <?php
                    echo $_SESSION['first_name']." ".$_SESSION['last_name'];
                    ?>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->



                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users" aria-hidden="true"></i>
                        <p>
                            Customer
                            <i class="right fas fa-caret-left "></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo ROOT; ?>customer/register.php" class="nav-link">
                                <i class="fa fa-plus-square nav-icon" aria-hidden="true"></i>
                                <p>Customer Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo ROOT; ?>customer/profile.php" class="nav-link">
                                <i class="fa fa-user-circle nav-icon" aria-hidden="true"></i>
                                <p>Customer Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo ROOT; ?>customer/feedback.php" class="nav-link">
                                <i class="fa fa-comments nav-icon" aria-hidden="true"></i>
                                <p>Customer Feedback</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>
                            Employee
                            <i class="right fas fa-caret-left "></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo ROOT; ?>employee/register.php" class="nav-link">
                                <i class="fa fa-plus-square nav-icon"></i>
                                <p>Register Employee</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-print"></i>
                        <p>
                            Equipment
                            <i class="right fas fa-caret-left "></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo ROOT; ?>equipment/add.php" class="nav-link">
                                <i class="fa fa-plus-square nav-icon"></i>
                                <p>Add Equipment</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cubes" aria-hidden="true"></i>
                        <p>
                            Inventory
                            <i class="right fas fa-caret-left "></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo ROOT; ?>inventory/add.php" class="nav-link">
                                <i class="fa fa-plus-square nav-icon" aria-hidden="true"></i>
                                <p>Add Item</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart" aria-hidden="true"></i>
                        <p>
                            Order
                            <i class="right fas fa-caret-left "></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo ROOT; ?>order/add.php" class="nav-link">
                                <i class="fa fa-plus-square nav-icon" aria-hidden="true"></i>
                                <p>Add Order</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-credit-card" aria-hidden="true"></i>
                        <p>
                            Payment
                            <i class="right fas fa-caret-left "></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo ROOT; ?>payment/add.php" class="nav-link">
                                <i class="fa fa-plus-square nav-icon" aria-hidden="true"></i>
                                <p>Add Payment</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book" aria-hidden="true"></i>
                        <p>
                            Product
                            <i class="right fas fa-caret-left "></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo ROOT; ?>product/add.php" class="nav-link">
                                <i class="fa fa-plus-square nav-icon" aria-hidden="true"></i>
                                <p>Add Product</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-industry" aria-hidden="true"></i>
                        <p>
                            Subcontractor
                            <i class="right fas fa-caret-left "></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo ROOT; ?>subcontractor/register.php" class="nav-link">
                                <i class="fa fa-plus-square nav-icon" aria-hidden="true"></i>
                                <p>Subcontractor Registration</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-truck" aria-hidden="true"></i>
                        <p>
                            Supplier
                            <i class="right fas fa-caret-left "></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo ROOT; ?>supplier/register.php" class="nav-link">
                                <i class="fa fa-plus-square nav-icon" aria-hidden="true"></i>
                                <p>Supplier Registration</p>
                            </a>
                        </li>
                    </ul>
                </li>

                
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user" aria-hidden="true"></i>
                        <p>
                            Manage User
                            <i class="right fas fa-caret-left "></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo ROOT; ?>user/create_module.php" class="nav-link">
                                <i class="fa fa-plus-square nav-icon" aria-hidden="true"></i>
                                <p>Create Module</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo ROOT; ?>user/create_user.php" class="nav-link">
                                <i class="fa fa-plus-square nav-icon" aria-hidden="true"></i>
                                <p>Create User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo ROOT; ?>user/assign_moule.php" class="nav-link">
                                <i class="fa fa-plus-square nav-icon" aria-hidden="true"></i>
                                <p>Assign module</p>
                            </a>
                        </li>
                    </ul>
                </li>

                
        
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<div class="content-wrapper">
<!--     Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-6">
<!--                    <br>  <h1 class="m-0 text-dark">Dashboard v3</h1>-->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
<!--                        <li class="breadcrumb-item active">
                    <?php
                    //echo $_SESSION['first_name']." ".$_SESSION['last_name'];
                    ?>
                </li>-->
                    </ol>
                </div> <!--/.col -->
          </div> <!--/.row -->
       </div><!--  /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">