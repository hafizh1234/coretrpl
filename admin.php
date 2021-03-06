<?php 
  session_start();
  require 'functions.php';
  if(!isset($_SESSION['admin'])){
    header("Location: loginadmin.php");
    exit;
  }
  //$user = $_SESSION['user'];
  if(isset($_POST['insert'])){
    if(tambah($_POST)){
      echo "<script>
              alert('Product inserted!');
            </script>
      ";
    }
    else{
      echo "<script>
              alert('Product insertion failed!');
            </script>
      ";
    }
  }
  if(isset($_POST['pengambilan'])){
    if (pengambilan($_POST)>0) {
      echo " <script>
        alert('Pengambilan dikonfirmasi.');
      </script>
      ";
    }
    else
     echo " <script>
        alert('Pengambilan gagal dikonfirmasi');
      </script>
      ";
  }
  if(isset($_POST['pengembalian'])){
    if (pengembalian($_POST)>0) {
      echo " <script>
        alert('Pengembalian dikonfirmasi.');
      </script>
      ";
    }
    else
     echo " <script>
        alert('Pengembalian gagal dikonfirmasi');
      </script>
      ";
  }
  $products = query("SELECT * FROM products");     
    $ordersc = query("SELECT * FROM orders WHERE status='CART'");
  $ordersb = query("SELECT * FROM orders WHERE status='BELUM DIAMBIL'");
  $orderss = query("SELECT * FROM orders WHERE status='BELUM DIKEMBALIKAN'");
  $history = query("SELECT * FROM orders WHERE status='SUKSES'"); 
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Administrator</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>

     <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
      <div class="container">
        <a class="navbar-brand" href="index.php"> Costum Rental</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="shop.php" class="nav-link">Shop</a></li>
            <li class="nav-item"><a href="index.php#bio" class="nav-link">About</a></li>
            <li class="nav-item"><a href="index.php#kontak" class="nav-link">Contact</a></li>
            <li class="nav-item cta cta-colored"><a href=<?php  if (isset($_SESSION['login'])) {
        echo "profile.php";
      } 
      else
        echo "login.php";
      ?> class="nav-link"><?php if (isset($_SESSION['login'])) {
        echo "Cart";
      } 
      else
        echo "Login";
      ?></a></li>

          </ul>
        </div>
      </div>
    </nav>
    <!-- END nav -->
		
		<div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-0 bread">ADMIN PANEL</h1>
            <p class="breadcrumbs"><a href="#orders">Orders</a>   <a href="#inputproduct">Input Product</a>   <a href="#products">Products</a>   <a href="#history">History</a>   <a href="logout.php">Logout</a></p>
            <p class="breadcrumbs"><span>Barang belum diambil</span></p>
            <p class="breadcrumbs"><span>Barang belum dikembalikan</span></p>
            <p class="breadcrumbs"><span>Transaksi sukses</span></p>
          </div>
        </div>
      </div>
    </div>
		
    <section class="ftco-section ftco-cart" id="belum">
      <div class="container">
        <div class="row">
          <div class="col-md-12 ftco-animate" >
            <div class="cart-list">
              <table class="table">
                <thead class="thead-primary">
                  <tr class="text-center">
                    <th>Belum diambil</th>
                    <th>Product</th>
                    <th>User</th>
                    <th>Price</th>
                    <th>Quantity</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($ordersb as $order):?>
                  <?php
                    $product_id = $order['product_id'];
                    $query = "SELECT * FROM products WHERE product_id='$product_id'";
                    $result = mysqli_query($db_users,$query);
                    $product = mysqli_fetch_assoc($result);
                    $order_id = $order['order_id'];
                    $product_name = $product['product_name'];
                    $product_bio = $product['product_bio'];
                    $product_price = $product['product_price'];
                    $quantity = $order['quantity'];
                    $username = $order['username'];
                  ?>
                  <form action="" method="POST">
                  <tr class="text-center" style="padding: 2px !important">
                    <!-- <td class="product-remove"><button class="btnaing" name="pengembalian">HAPUS</button></a></td> -->
                    <input type="hidden" name="order_id" value="<?php echo "$order_id" ?>"/>
                    <td><button class="btnaing" name="pengambilan" style="padding: 2px 15px !important;">Konfirmasi Pengambilan</button></td>
                    
                    <td class="product-name">
                      <h3><?= $product['product_name']?></h3>
                    </td>
                    <td> <?php echo"$username";?></td>
                    <!-- <input type="hidden" name="product_id" value="<?php echo "$product_id" ?>"/>
                    <input type="hidden" name="username" value="<?php echo "$username" ?>"/> -->
                    <td class="price">IDR <?= $product['product_price']?></td>
                    
                    <td class="quantity">
                      <?php echo "$quantity" ?>
                    </td>
                    <!-- <td class="total"><button class="btnaing" name="book">BOOKING</button></td> -->
                  </tr>
                  </form>
                  <?php endforeach; ?>
                  <!-- END TR-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-cart" id="belumdikembalikan">
      <div class="container">
        <div class="row">
          <div class="col-md-12 ftco-animate" >
            <div class="cart-list">
              <table class="table">
                <thead class="thead-primary">
                  <tr class="text-center">
                    <th>Belum dikembalikan</th>
                    <th>Product</th>
                    <th>User</th>
                    <th>Price</th>
                    <th>Quantity</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($orderss as $order):?>
                  <?php
                    $product_id = $order['product_id'];
                    $query = "SELECT * FROM products WHERE product_id='$product_id'";
                    $result = mysqli_query($db_users,$query);
                    $product = mysqli_fetch_assoc($result);
                    $order_id = $order['order_id'];
                    $product_name = $product['product_name'];
                    $product_bio = $product['product_bio'];
                    $product_price = $product['product_price'];
                    $quantity = $order['quantity'];
                    $username = $order['username'];
                  ?>
                  <form action="" method="POST">
                  <tr class="text-center">
                    <!-- <td class="product-remove"><button class="btnaing" name="hapus">HAPUS</button></a></td> -->
                    <input type="hidden" name="order_id" value="<?php echo "$order_id" ?>"/>
                    <td><button class="btnaing" name="pengembalian" style="padding: 2px 15px !important;">Konfirmasi Pengembalian</button></td>
                    
                    <td class="product-name">
                      <h3><?= $product['product_name']?></h3>
                    </td>
                    <td> <?php echo"$username";?></td>
                    <!-- <input type="hidden" name="product_id" value="<?php echo "$product_id" ?>"/>
                    <input type="hidden" name="username" value="<?php echo "$username" ?>"/> -->
                    <td class="price">IDR <?= $product['product_price']?></td>
                    
                    <td class="quantity">
                      <?php echo "$quantity" ?>
                    </td>
                    <!-- <td class="total"><button class="btnaing" name="book">BOOKING</button></td> -->
                  </tr>
                  </form>
                  <?php endforeach; ?>
                  <!-- END TR-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    
		<!-- <section class="ftco-section ftco-cart">
			<div class="container">
				<div class="row">
    			<div class="col-md-12 ftco-animate" id="orders">
    				<div class="cart-list">
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <th>Orders</th>
						        <th>Product</th>
						        <th>Price</th>
						        <th>Quantity</th>
						        <th>User</th>
						        <th>Status</th>
						      </tr>
						    </thead>
						    <tbody>
						      <tr class="text-center">
						        <td class="product-status"></td>
						        
						        <td class="product-name">
						        	<h3>Young Woman Wearing Dress</h3>
						        </td>
						        
						        <td class="price">$15.70</td>
						        
						        <td class="quantity">1</td>
					          	<td><p>username</p></td>
					          	<td><p>Barang belum diambil</p></td>
						        
						      </tr>
						      <tr class="text-center">
						        <td class="product-status"><a href="#">Konfirmasi Pengembalian</a></td>
						        
						        <td class="product-name">
						        	<h3>Young Woman Wearing Dress</h3>
						        </td>
						        
						        <td class="price">$15.70</td>
						        
						        <td class="quantity">1</td>
					          	<td><p>username</p></td>
					          	<td><p>Barang sudah diambil</p></td>
						        
						      </tr>
						    </tbody>
						  </table>
					  </div>
    			</div>
    		</div>
			</div>
		</section> -->

		<section class="ftco-section ftco-cart">
			<div class="container">
				<div class="row" >
          <div class="col-md-3"></div>
					<div class="col-md-6" id="inputproduct">
					<form action="" method="POST" enctype="multipart/form-data">
							<h3>Input product</h3>
							<div class="form-group">
    						<input type="text" name="product-name" placeholder="Product name" class="form-control input-lg" style="padding: 0" >
    						</div>
    						<div class="form-group">
    						<input type="text" name="product-bio" placeholder="Product bio" class="form-control input-lg" style="padding: 0">
    						</div>
    						<div class="form-group">
    						<input type="number" name="product-price" placeholder="Price" class="form-control input-lg" style="padding: 0">
    						</div>
    						<div class="form-group">
    						<input type="number" name="product-quantity-s" placeholder="S Size Quantity" class="form-control input-lg" style="padding: 0">
    						</div>
    						<div class="form-group">
    						<input type="number" name="product-quantity-m" placeholder="M Size Quantity" class="form-control input-lg" style="padding: 0">
    						</div>
    						<div class="form-group">
    						<input type="number" name="product-quantity-l" placeholder="L Size Quantity" class="form-control input-lg" style="padding: 0">
    						</div>
    						<div class="form-group">
    						<input type="number" name="product-quantity-xl" placeholder="XL Size Quantity" class="form-control input-lg" style="padding: 0">
    						</div>
    						<div class="form-group"><p>Image: 
    							<input type="file" name="image" id="uploadimage" class="input-lg"></p>
    						</div>
    							<button type="submit" name="insert" style="float:right;margin:0;border: 1px solid #964B00;padding: 0px 30px">INPUT</button>
    				</form>
    				</div>
            
    			<div class="col-md-12 ftco-animate"	style="padding-top: 3rem;" id="products">
    				<div class="cart-list">
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <th>&nbsp;</th>
						        <th>Product</th>
						        <th>Price</th>
						        <th>Quantity</th>
						      </tr>
						    </thead>
						    <tbody>
                
                  <?php foreach ($products as $product):?>
						      <tr class="text-center">
						        
						        <td class="image-prod"><div class="img" style="background-image:url(images/<?= $product['image']?>);"></div></td>
						        
						        <td class="product-name">
						        	<h3><?= $product['product_name']?></h3>
						        	<p><?= $product['product_bio']?></p>
						        </td>
						        
						        <td class="price">IDR <?= $product['product_price']?></td>
						        
						        <td class="quantity">
						        	<p>S <?= $product['product_quantity_s']?></p>
						        	<p>M <?= $product['product_quantity_m']?></p>
						        	<p>L <?= $product['product_quantity_l']?></p>
						        	<p>XL <?= $product['product_quantity_xl']?></p>
						        	
					          </td>
                  <?php endforeach; ?>
						      </tr><!-- END TR-->
						    </tbody>
						  </table>
					  </div>
    			</div>
    		</div>
			</div>
	</section>

  <section class="ftco-section ftco-cart" id="history">
      <div class="container">
        <div class="row">
          <div class="col-md-12 ftco-animate" >
            <div class="cart-list">
              <table class="table">
                <thead class="thead-primary">
                  <tr class="text-center">
                    <th>History</th>
                    <th>Product</th>
                    <th>User</th>
                    <th>Price</th>
                    <th>Quantity</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($history as $order):?>
                  <?php
                    $product_id = $order['product_id'];
                    $query = "SELECT * FROM products WHERE product_id='$product_id'";
                    $result = mysqli_query($db_users,$query);
                    $product = mysqli_fetch_assoc($result);
                    $order_id = $order['order_id'];
                    $product_name = $product['product_name'];
                    $product_bio = $product['product_bio'];
                    $product_price = $product['product_price'];
                    $quantity = $order['quantity'];
                    $username = $order['username'];
                  ?>
                  <tr class="text-center">
                    <!-- <td class="product-remove"><button class="btnaing" name="hapus">HAPUS</button></a></td>
                    <input type="hidden" name="order_id" value="<?php echo "$order_id" ?>"/> -->
                    <td><br></td>
                    <td class="product-name">
                      <h3><?= $product['product_name']?></h3>
                    </td>
                    <td> <?php echo"$username";?></td>
                    <!-- <input type="hidden" name="product_id" value="<?php echo "$product_id" ?>"/>
                    <input type="hidden" name="username" value="<?php echo "$username" ?>"/> -->
                    <td class="price">IDR <?= $product['product_price']?></td>
                    
                    <td class="quantity">
                      <?php echo "$quantity" ?>
                    </td>
                    <!-- <td class="total"><button class="btnaing" name="book">BOOKING</button></td> -->
                  </tr>
                  <?php endforeach; ?>
                  <!-- END TR-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>


     <!-- <section class="ftco-section ftco-cart">
      <div class="container">
        <div class="row">
          <div class="col-md-12 ftco-animate" id="history">
            <div class="cart-list">
              <table class="table">
                <thead class="thead-primary">
                  <tr class="text-center">
                    <th>History</th>
                    <th>&nbsp;</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="text-center">
                    <td class="product-remove"></td>
                    
                    <td class="image-prod"><div class="img" style="background-image:url(images/product-4.jpg);"></div></td>
                    
                    <td class="product-name">
                      <h3>Young Woman Wearing Dress</h3>
                      <p>Far far away, behind the word mountains, far from the countries</p>
                    </td>
                    
                    <td class="price">$15.70</td>
                    
                    <td class="quantity">
                      1
                    </td>
                    
                    <td class="total">$15.70</td>
                    <td>Success</td>
                  </tr>END TR
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section> -->

    
		
    <footer class="ftco-footer bg-light ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Modist</h2>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Menu</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">Shop</a></li>
                <li><a href="#" class="py-2 d-block">About</a></li>
                <li><a href="#" class="py-2 d-block">Journal</a></li>
                <li><a href="#" class="py-2 d-block">Contact Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Help</h2>
              <div class="d-flex">
	              <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
	                <li><a href="#" class="py-2 d-block">Shipping Information</a></li>
	                <li><a href="#" class="py-2 d-block">Returns &amp; Exchange</a></li>
	                <li><a href="#" class="py-2 d-block">Terms &amp; Conditions</a></li>
	                <li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
	              </ul>
	              <ul class="list-unstyled">
	                <li><a href="#" class="py-2 d-block">FAQs</a></li>
	                <li><a href="#" class="py-2 d-block">Contact</a></li>
	              </ul>
	            </div>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</p>
          </div>
        </div>
      </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>

  <script>
		$(document).ready(function(){

		var quantitiy=0;
		   $('.quantity-right-plus').click(function(e){
		        
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        
		        // If is not undefined
		            
		            $('#quantity').val(quantity + 1);

		          
		            // Increment
		        
		    });

		     $('.quantity-left-minus').click(function(e){
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        
		        // If is not undefined
		      
		            // Increment
		            if(quantity>0){
		            $('#quantity').val(quantity - 1);
		            }
		    });
		    
		});
	</script>
    
  </body>
</html>