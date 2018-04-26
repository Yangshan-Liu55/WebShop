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

    <!-- Form -->
    <div style="text-align: center">      
      <form action="create.php" method="post" style="text-align: left">
        <h5>CREATE ACCOUNT</h5>
        <hr>
        <label for="user">User Name</label>
        <input type="text" name="user" id="user" required placeholder="User Name">
        <label for="epost">E-mail</label>
        <input type="text" name="epost" id="epost" required placeholder="E-post">
        <label for="address">Address</label>
        <input type="text" name="address" id="address" required placeholder="Address">
        <label for="tel">Telephone</label>
        <input type="text" name="tel" id="tel" required placeholder="Telephone">
        <label for="password">Password</label>
        <input type="password" name="password" id="password"  required placeholder="Password"><br>   
        <button class="btn btn-info mx-3">CREATE</button>
        <hr><br>            
      </form>
      <a href='logIn.php' class='btn btn-outline-primary'>LOG IN</a>            
    </div>

    <?php

    if($_SERVER['REQUEST_METHOD']==='POST'){

    print_r($_POST);
    require('connect.php');
    $user = $_POST['user'];
    $email = $_POST['epost'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    $password = $_POST['password'];
    $password = md5($password);

    $sql = "INSERT INTO Client VALUES ('','$user','$email','$password','$address','$tel')";
    // echo $sql;
    mysqli_query($connection, $sql) 
    or die(mysqli_error($connection));

    $query = "SELECT * FROM Client WHERE Email = '$email' AND Password ='$password'";
    $result = mysqli_query($connection, $query) or die("Wrong email or wrong password!".mysqli_error($connection));
    if($client = $result->fetch_assoc()){   
    $_SESSION["user"]=$client['User'];
    // echo "<pre>";
    // print_r ($_SESSION); 
    // echo "</pre>";
    echo '<script>window.location="index.php"</script>';
    } 
    else {
      echo "Wrong email or wrong password!";
    }   
    }
    ?>    
    
<br><br><br>
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

<!-- <?php 
echo "<pre>My Session ";
print_r ($_SESSION); 
echo "</pre>";
?> -->

  </body>   
</html>