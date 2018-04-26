<?php   
 session_start();  
 require('connect.php');
 if(isset($_POST["buy"]))  
 { if(isset($_SESSION["shopping_cart"]))  // if the session variable has already some items.
  {  $item_array_id = array_column($_SESSION["shopping_cart"], "item_id"); 
//The array_column() function returns the values from a single column(only a value of a row, item_id(item_id can be a array)) in the input array(shopping_cart).
    if(!in_array($_GET["id"], $item_array_id))  // if no the same item-id in the session.
    { $count = count($_SESSION["shopping_cart"]); // total items shopping_cart length
      $item_array = array(  
        'item_id' => $_GET["id"],  
        'item_name'  =>  $_POST["hidden_name"],
        'item_source'  =>  $_POST["hidden_source"],
        'item_price'  =>  $_POST["hidden_price"],
        'item_unit'  =>  $_POST["hidden_unit"],  
        'item_quantity' =>  $_POST["quantity"]  
      ); 
      $_SESSION["shopping_cart"][$count] = $item_array;      
    }
    // if the session has already an item whoes id is the same as GET["id"].  
    else  
    { echo '<script>alert("Item Already Added")</script>';  
      echo '<script>window.location="shoppingCart.php"</script>'; 
    }    
  }  
  else // if the session variable is empty.
  { $item_array = array(  
      'item_id' => $_GET["id"],  
      'item_name'  =>  $_POST["hidden_name"],
      'item_source'  =>  $_POST["hidden_source"],
      'item_price'  =>  $_POST["hidden_price"],
      'item_unit'  =>  $_POST["hidden_unit"],  
      'item_quantity' =>  $_POST["quantity"]  
    );  
    $_SESSION["shopping_cart"][0] = $item_array;  
  }  
 }  
 if(isset($_GET["action"]))  
 {  if($_GET["action"] == "delete")  
    { foreach($_SESSION["shopping_cart"] as $keys => $values)  
      { if($values["item_id"] == $_GET["id"])  
        { unset($_SESSION["shopping_cart"][$keys]);  
          echo '<script>alert("Are you sure to remove this item?")</script>';  
          echo '<script>window.location="shoppingCart.php"</script>';// update
        }  
      }  
    }
    elseif($_GET["action"] == "plus")
    {foreach($_SESSION["shopping_cart"] as $keys => $values)  
      { if($values["item_id"] == $_GET["id"])  
        { $_SESSION["shopping_cart"][$keys]["item_quantity"]=$_SESSION["shopping_cart"][$keys]["item_quantity"]+1; 
          // $_SESSION["shopping_cart"][$keys]["item_quantity"]=$_GET["quantity"]+1;   
          echo '<script>window.location="shoppingCart.php"</script>';// update
        }
      }
    }
    elseif($_GET["action"] == "minus")
    {foreach($_SESSION["shopping_cart"] as $keys => $values)  
      { if($values["item_id"] == $_GET["id"]) 
        if($_SESSION["shopping_cart"][$keys]["item_quantity"]>1) 
        { 
          $_SESSION["shopping_cart"][$keys]["item_quantity"]=$_SESSION["shopping_cart"][$keys]["item_quantity"]-1; 
          echo '<script>window.location="shoppingCart.php"</script>';// update
          
        }
        else
        {
          unset($_SESSION["shopping_cart"][$keys]);  
          echo '<script>alert("Are you sure to remove this item?")</script>';  
          echo '<script>window.location="shoppingCart.php"</script>';// update
        }
      }
    }
 }  
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
  <body>
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
        </ul>
      </div>
      <!-- End of Menu -->
      <!-- Right Nav  -->      
      <a href="shoppingCart.php" class="float-right"><img src="images/shopcart1.png" width="25" height="25" class="d-inline-block align-top" style="border-radius:50%;" alt="cart"></a>                   
      
    </nav>
    </div>
    <div style="background-color: white; height:105px;"></div>
    <!-- End of Navigation -->
    
    <!-- Order List -->
    <div style="clear:both"></div>  
    <br />
    <div align="center">
      <h3>Order List</h3>      
      <p align="right"><a class="btn btn-outline-dark" style="border: none" href="sendOrder.php">SEND ORDER</a></p>
      <!-- Shopping List -->
      <div class="table-responsive"> 
        <table class="table table-bordered">  
          <tr><th width="20%">Picture</th>
            <th width="30%">Item Name</th>  
            <th width="10%">Quantity</th>  
            <th width="10%">Price</th>  
            <th width="10%">Total</th>  
            <th width="10%">Action</th> </tr>  
          <?php   
            if(!empty($_SESSION["shopping_cart"]))  
            { $total = 0;  
              foreach($_SESSION["shopping_cart"] as $keys => $values)  
              {  
          ?>  
          <tr><td>
            <img src="<?php echo $values['item_source']; ?>" height:30%, width:30%>            
          </td> 
            <td><?php echo $values["item_name"]; ?></td>
            <td><?php echo $values["item_quantity"]; ?>
            <span><a href="shoppingCart.php?action=plus&id=<?php echo $values["item_id"]; ?>">+</a></span>
              <span><a href="shoppingCart.php?action=minus&id=<?php echo $values["item_id"]; ?>">-</a></span>
            </td>
            <td><?php echo $values["item_unit"].$values["item_price"]; ?></td>  
            <td><?php echo $values["item_unit"].number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>  
            <td><a class="btn btn-primary btn-sm" href="shoppingCart.php?action=delete&id=<?php echo $values["item_id"]; ?>">Remove</a></td></tr> 
          <?php  
            $total = $total + ($values["item_quantity"] * $values["item_price"]);  
              }  
          ?>  
          <tr><td colspan="4" align="right">Total</td>  
            <td align="right">€<?php echo number_format($total, 2); ?></td>  
            <td></td></tr>  
          <?php  
            }  
          ?>  
        </table>           
      </div> 
    </div>
    <br><br> 
    <a href="index.php" class="float-left btn btn-outline-dark" style="text-decoration: none; border: none; ">CONTINUE SHOPPING</a>
    <!-- End of Order List --> 

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
    </div>
    <!-- End of Copyright -->   
   
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