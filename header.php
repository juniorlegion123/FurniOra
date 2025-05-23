<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title> Furniora </title>
  <meta charset="utf-8">
  <meta name="description" content="" >
  <meta name="keywords" content="" >
  <meta name="author" content="" >
  <link rel="stylesheet" type="text/css" href="css/furniture.css" media="all" />
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/login.css">
  <link rel="stylesheet" type="text/css" href="css/slider.css" />
  <link href="https://fonts.googleapis.com/css?family=Josefin+Slab|Lobster" rel="stylesheet">
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="css/jquery.bxslider.css" rel="stylesheet">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script> 
  <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
  <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" src="js/jquery.eislideshow.js"></script>
  <script type="text/javascript" src="js/jquery.bxSlider.min.js"></script>
  <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
  <script async="" type="text/javascript" src="js/script.js"></script>

</head>

<body>
  <!--Main Container starts -->
  <div class="main_wrapper">

    <!--Header Starts from here-->
    <div class="header_wrapper" style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background-color: #f4f4f4;">
  <div style="font-family: 'Lobster', cursive; font-size: 40px; color: #333;">
    <a href="index.php" style="text-decoration: none; color: #333;">FURNIORA</a>
  </div>
  <div style="text-align: right;">
    <div style="font-family: 'Josefin Slab', serif; font-size: 18px; color: #555;">
      Great Place. Great Mind.<br>
      <strong style="color: #000;">Discuss Great Ideas</strong>
    </div>
    <a href="all_products.php" style="display: inline-block; margin-top: 10px; padding: 5px 12px; background-color: #333; color: #fff; text-decoration: none; border-radius: 4px;">Shop Now</a>
  </div>
</div>

    <!--Header ends here-->
    <!--Navigation Bar starts -->
    <div id="navbar">
<!-- -->
        <ul id="menu">
          <li><a href="index.php" >Home</a></li>
          <li><a href="all_products.php" >All Products</a></li>
          
          <?php
          if(!isset($_SESSION['customer_email'])){
            echo "<li><a href='customer_register.php'>Sign up</a></li>";
          }else{
            echo "<li><a href='customer/my_account.php'>My Account</a></li>";
          }?>
          <li><a href="cart.php" >Shopping Cart</a></li>
          <li><a href="contact.php" >Contact Us</a></li>
        </ul>

        <div id="form" >
          <form method="get" action="results.php" enctype="multipart/form-data" style="float: left;">
              <input type="text" name ="user_query" placeholder="Search a Product"></input>
              <input type="submit" name="search" value="Search"></input>
          </form>
          <div id="log_user">
             <?php
                if(!isset($_SESSION['customer_email'])){
                    echo "<a href='checkout.php'>Login</a>";
                }
                  else {
                    echo "<a href='logout.php'>Logout</a>";
                  }

                 ?>
          </div>
        </div>

    </div>
    <!--Navigation Bar ends -->