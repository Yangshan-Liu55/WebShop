<?php
 session_start();  
 ?>
<!DOCTYPE html>
<html lang="en">    
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Coca-Clothes</title>    
    <!-- Bootstrap CSS -->
    <link rel='stylesheet prefetch' href='https://cdn.jsdelivr.net/foundation/5.0.2/css/foundation.css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" 
    integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" 
    crossorigin="anonymous">
    <!-- Customer CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Anton|Dancing+Script|Montserrat|PT+Sans|Source+Sans+Pro|Vollkorn+SC" rel="stylesheet">
  
  </head>    
  <body id="pageTop">
    <!-- Logo -->
    <div class="fixed-top">
      <div style="background-color: white;">
        <span><a href="index.php" class="myLogo" style="text-decoration: none; color: black">Coca-Clothes</a></span>
        <a href="logIn.php" class="float-right" style="text-decoration: none; color: black">
        <?php
        echo $_SESSION['user'] ?? 'LOG IN';
        ?>
        </a>        
      </div>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-md navbar-light bg-dark" role="navigation">          
      <!-- collapse plugin and other navigation toggling behaviors. -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" 
        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Menu -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="nav navbar-nav mr-auto">
          <li class="nav-item active"><a href="index.php" class="nav-link text-white">HOME</a><span class="sr-only">(current)</span></li>
          <li class="nav-item"><a href="women.php" class="nav-link text-white">WOMEN</a></li>
          <li class="nav-item"><a href="men.php" class="nav-link text-white">MEN</a></li>                
          <li class="nav-item"><a href="#contact" class="nav-link text-white">CONTACT</a></li>
          <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      ABOUT US
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item text-secondary" href="api.php">PRODUCT JSON LIST</a>
                    </div>
                </li>
        </ul>
      </div>
      <!-- End of Menu -->
      <!-- Right Nav  -->      
      <a href="shoppingCart.php" class="float-right"><img src="images/shopcart1.png" width="25" height="25" class="d-inline-block align-top" style="border-radius:50%;" alt="cart"></a>                   
      
    </nav>
    </div>
    <div style="background-color: white; height:105px;"></div>
    <!-- End of Navigation -->   

    <!-- Slides -->
    <div id="onSale" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#onSale" data-slide-to="0" class="active"></li>
        <li data-target="#onSale" data-slide-to="1"></li>
        <li data-target="#onSale" data-slide-to="2"></li>
      </ol>     
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block w-100 h-60" src="https://cdn.shopify.com/s/files/1/1011/6760/t/15/assets/link_tile_1_1024x1024.jpg?4364792633024027688" alt="On Sales 1">
        </div>     
        <div class="carousel-item">
          <img class="d-block w-100 h-60" src="images/onSale2.jpg" alt="On Sales 2">
        </div>      
        <div class="carousel-item">
          <img class="d-block w-100 h-60" src="images/onSale3.jpg" alt="On Sales 3">              
        </div>           
      </div>     
      <!-- Left and right controls -->
      <a class="carousel-control-prev" href="#onSale" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#onSale" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <!-- End of Slides -->

  <!-- Product list. From database -->
  <?php
    require('connect.php');

    $query="SELECT * FROM Product";
    
    $table=mysqli_query($connection, $query) 
    or die(mysql_error($connection));

    if($table->num_rows) :  // if select has result
      echo "<div class='row mx-auto'>";
      while($row=$table->fetch_assoc()) { // define a variable row and equal table's one row value. Or while($row=mysqli_fetch_associ($table))
  ?>
  <div class='col-xs-12 col-md-6 col-lg-4 p-3' style='text-align:center'>
    <form method='post' action="shoppingCart.php?action=add&id=<?php echo $row['Articlenr']; ?>">
      <div style='height 105px;'>
        <img style='height 100px;' alt='' src="<?php echo $row['Source']; ?>">
      </div>
      <div style='height 30px;'>
        <a href='' style='text-decoration: none; color: black'>
          <h5><?php echo $row['Name']; ?></h5>
          <h6><?php echo $row['Unit'].$row['Price']; ?></a></h6><br>
          <input type='hidden' name='hidden_source' value="<?php echo $row['Source']; ?>">
          <input type='hidden' name='hidden_name' value="<?php echo $row['Name']; ?>">
          <input type='hidden' name='hidden_unit' value="<?php echo $row['Unit']; ?>">
          <input type='hidden' name='hidden_price' value="<?php echo $row['Price']; ?>">
          <input type='text' name='quantity' value="1">
          <input type='submit' name='buy' class='btn btn-outline-dark' value='BUY'>
        </a>
      </div>
    </form>
  </div>
  <?php
      }
      echo "</div>";
    endif;
    // header('Location: index.php'); 
  ?>
<!-- Contact -->
<section id="contact" style="background-color: rgb(78, 78, 78);">
  <br><h1 style="text-align: center; color: white;">Contact</h1><br>
  <div style="padding-bottom:1rem;" class="text-white">
    <form method="post" action="sendMail.php">
      <input type="text" placeholder="Name" name="name" required style="margin-right:1rem; margin-bottom:1rem; width:100%">
      <input type="email" placeholder="Email" name="email" required style="margin-right:1rem; margin-bottom:1rem; width:100%">
      <textarea name="message" placeholder="Message.." required style="margin-right:1rem; margin-bottom:1rem; height:100px; width:100%"></textarea>
      <button class="btn btn-muted btn-sm" type="submit">Send</button>
      <hr>
      <h8 class="text-white">CALL US: +4672 039 61 87</h8>
      <h8 class="text-white ml-4">MAIL US: <a href="sendMail.php" class="text-white">cocaclothes@gmail.com</a></h8> 
      <p class="text-white ml-4">SHOW : <a href="api.php" class="text-white">PRODUCT.JSON</a></p> 
    </form> 
  </div>
</section><!-- End of Contact -->

    <!-- Copyright -->
    <div style="background-color: black;">
      <p class="text-white ml-4">&copy; Copyright 2017 Coca-Clothes</p>
    </div><!-- End of Copyright -->
   
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- collapse can only work with JAVASCRIPT!!! Anars inte fungera!! -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

  </body>   
</html>