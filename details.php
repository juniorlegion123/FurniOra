<?php
include("includes/db.php");
include("functions/functions.php");
include("header.php");
?>
  
 


    <!--Content starts-->
    <div class="content_wrapper">
        <div id="left_sidebar">
            <div id="sidebar_title"> Categories </div>
            <ul id="cats">
              <?php
                  getCats();
               ?>

            </ul>

            <div id="sidebar_title"> Brands </div>
            <ul id="cats">
              <?php getBrands(); ?>

            </ul>

        </div>
        <div id="right_content">
          <div id="headline">
              <div id="headline_content">
                  <?php
                      if(!isset($_SESSION['customer_email'])){
                        echo "<b>Welcome Guest !</b> <b style='color:yellow;'>Shopping Cart</b>";
                      }
                      else {
                        echo "<b>Welcome: " ."<span style='color:pink;'>". $_SESSION['customer_email']."</span></b>"."<b style='color:yellow;'>Your Shopping Cart</b>";
                      }
                   ?>


                  <span>-  Total Items: <?php items(); ?> - Total Price: ₹ <?php total_price(); ?>
                    <a class="cart_img"  href="cart.php" style="float:right;margin-left: 5px;"><img src="images/Cart-Icon.png" width="30px" height="30px"></a></span>



              </div>
          </div>
            <!--Headline ends her-->
            <div id="products_box">
                <?php
                if(isset($_GET['pro_id'])){
                  $product_id=$_GET['pro_id'];
                  $get_products="select * from products where product_id='$product_id'";
                  $run_products=mysqli_query($con,$get_products);
                  while($row_products=mysqli_fetch_array($run_products)){
                    $pro_id=$row_products['product_id'];
                    $pro_title=$row_products['product_title'];
                    $pro_cat=$row_products['cat_id'];
                    $pro_brand=$row_products['brand_id'];
                    $pro_desc=$row_products['product_desc'];
                    $pro_price=$row_products['product_price'];
                    $pro_image1=$row_products['product_img1'];
                    $pro_image2=$row_products['product_img2'];
                    $pro_image3=$row_products['product_img3'];
                    echo "
                      <div id='single_product' class='details_page'>
                      <h3> $pro_title</h3><hr>
                      <img src='admin_area/product_images/$pro_image1' width:'180' height='180'/>
                      <img src='admin_area/product_images/$pro_image2' width:'180' height='180'/>
                      <img src='admin_area/product_images/$pro_image3' width:'180' height='180'/><br>
                      <p><b>Price: ₹$pro_price</b><p>
                      <p>$pro_desc</p>
                      <a id='detail_link' href='all_products.php' style='float:left;'>Go Back</a>
                      <a id='add_cart_link' href='all_products.php?add_cart=$pro_id' ><span>Add to Cart</span></a>
                      </div>  ";
                  }


                }



                ?>
            </div>


        </div>





    </div>
    <!--Content ends-->


 <?php include("footer.php"); ?>