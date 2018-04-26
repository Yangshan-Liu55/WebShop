<?php 
session_start(); 
require('connect.php');

if (isset($_SESSION["user"]))
{ 
    $mailTo=$_SESSION["userEmail"];
    $user=$_SESSION["user"];

  if(isset($_SESSION["shopping_cart"])) 
  { 
    // OrderNumber, if the table(OrderList) is empty, Order Number = 1, otherwise Order Number + 1
    $query="SELECT OrderNr FROM OrderList ORDER BY OrderNr DESC LIMIT 1";          
    $result=mysqli_query($connection, $query) 
        or die(mysql_error($connection));  
    if($result->num_rows) // if select has result
    {  
    $row=mysqli_fetch_array($result); 
    $ordernr=$row['OrderNr'];
    $ordernr=$ordernr+1;
    }
    else { $ordernr = 1; }
    // the item number in an order: 
    $itemnr=0;
    $userid = $_SESSION["userid"];

    // Message information of the email:
    $message="Hi! ".$user.", Here is your order list: \nOrder Number: ".$ordernr." \n";
    $summary=0;
    foreach($_SESSION["shopping_cart"] as $keys => $values)
    {
    $itemnr=$itemnr+1;
    $articlenr = $values["item_id"];
    $name = $values["item_name"];
    $quantity = $values["item_quantity"];
    $price = $values["item_price"];
    $unit = $values["item_unit"];
    // Add to database table: OderList
    $mysql = "INSERT INTO OrderList VALUES ('$ordernr','$itemnr','$userid','$articlenr','$name','$quantity','$price', '$unit', CURRENT_TIMESTAMP)";
    mysqli_query($connection, $mysql) or die(mysqli_error($connection));

    // message information for the order email
    $message.="\nItem: ".$values['item_name']. "\n";
    $message.="Price: ".$values['item_price']. "\n";
    $message.="Quantity: ".$values['item_quantity']. "\n";   
    $message.="Total: ".$values['item_unit'].number_format($values['item_quantity'] * $values['item_price'], 2). "\n";
    $summary = $summary+$values['item_quantity'] * $values['item_price'];  
    }
    $message.="\n    Summary: " . $_SESSION["shopping_cart"]['item_unit'] .number_format($summary, 2). "\n";      
  }
  else{ $message="You haven't ordered anything from us.". "\n"."Welcome to Coco-Clothes again!"; }
  }
else { echo '<script>alert("Please log in first!")</script>';}   

$subject = "Your Order From Coco-Clothes";
$headers = "From: coco-clothes@gmail.com";
// Mail to the client
mail($mailTo,$subject,$message,$headers); 
echo "Your Order Sent. Please check your mail-box: ".$mailTo.", even in spam mailbox.<br>";
echo "<br><a href='index.php'><button>Back</button></a>";

// delete the shopping cart information after sending email
unset($_SESSION['shopping_cart']);

// echo "<pre>My Session ";
// print_r ($_SESSION); 
// echo "</pre>";
?>