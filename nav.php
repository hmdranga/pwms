<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?php echo ROOT; ?>dashboard.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <!--<a href="#" class="nav-link">Contact</a>-->
        </li>
    </ul>

    <!-- SEARCH FORM -->
<!--    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>-->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
         <!--Messages Dropdown Menu--> 
<!--        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                     Message Start 
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
                     Message End 
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                     Message Start 
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
                     Message End 
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                     Message Start 
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
                     Message End 
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>-->
         <!--Notifications Dropdown Menu--> 
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
            <a class="nav-link" href="<?php echo ROOT; ?>logout.php" role="button"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo ROOT; ?>dashboard.php" class="brand-link">
        <img src="<?php echo ROOT; ?>images/logo1.jpg" alt="company logo" class="brand-image img-rounded elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">The D Ads Digital</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image"><?php
                if ($_SESSION['profile_image'] == NULL) {
            ?>
                                                <img src="<?php echo ROOT; ?>images/no_image.png" alt="empty User image" class="img-circle elevation-2" >
                                    <?php } else { ?>
                                                <img src="<?php echo ROOT; ?>images/<?php echo $_SESSION['profile_image']; ?>" alt="User Image" class="img-circle elevation-2">
                                        <?php
                                    }
                                    ?>
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <?php
                    echo $_SESSION['first_name'] . " " . $_SESSION['last_name'];
                    ?>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <?php
                $sql_parent = "SELECT * FROM tb_user_module LEFT JOIN tb_module ON tb_module.module_id=tb_user_module.module_id WHERE tb_user_module.user_id='" . $_SESSION['user_id'] . "'AND LENGTH(tb_user_module.module_id)=2";
                $result_parent = $conn->query($sql_parent);
                ?>
                <?php
                if ($result_parent->num_rows > 0) {
                    while ($row_parent = $result_parent->fetch_assoc()) {
                        ?>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="<?php echo $row_parent['menu_icon']?>" aria-hidden="true"></i>
                                <p>
                                    <?php echo $row_parent['description']; ?>
                                    <i class="right fas fa-caret-left "></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php
                                $sql_sub = "SELECT * FROM tb_user_module LEFT JOIN tb_module ON tb_module.module_id=tb_user_module.module_id WHERE tb_user_module.user_id='" . $_SESSION['user_id'] . "' AND LENGTH(tb_user_module.module_id)=4 AND SUBSTR(tb_user_module.module_id,1,2)='" . $row_parent['module_id'] . "'";
                                $result_sub = $conn->query($sql_sub);
                                ?>
                                <?php
                                if ($result_sub->num_rows > 0) {
                                    while ($row_sub = $result_sub->fetch_assoc()) {
                                        ?>
                                        <li class="nav-item">
                                            <?php
                                            $path=ROOT.$row_sub['module']."/".$row_sub['view'].".php";
                                            ?>
                                            <a href="<?php echo $path; ?>" class="nav-link">
                                                <i class="<?php echo $row_sub['menu_icon']; ?>" aria-hidden="true"></i>
                                                <p><?php echo $row_sub['description']; ?></p>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>


                            </ul>
                        </li>

                        <?php
                    }
                }
                ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<div class="content-wrapper">
   
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">