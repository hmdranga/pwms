<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location:login.php');
}
?>
<?php include 'config.php'; ?>
<?php include 'helper.php'; ?>
<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
<!--title name-->
  <title>PWMS</title>
  <!--title image-->
  <link rel = "icon" type = "image/png" href = "<?php echo ROOT; ?>images/20638569_259745781197162_4269375431305161305_n.png">
  <!--fontawsome css connection-->
  <link rel="stylesheet" href="<?php echo ROOT;?>plugins/fontawesome-free/css/all.min.css">
  
  <link href="<?php echo ROOT;?>css/mystyle.css" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" href="<?php echo ROOT;?>dist/css/adminlte.min.css">

</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
    