<?php
//  session_start(); 

if (isset($_REQUEST['email'])) // Contact if the form filled
{
$email = $_REQUEST['email'] ;
$name = $_REQUEST['name'] ;
$message = $_REQUEST['message'] ;
mail( "yangshan.liu55@gmail.com", "Subject: $name", $message, "From: $email" );
echo "Your message is sent!<br>";
echo "<a href='index.php'><button>Back</button></a>";
}
else  // if the form not filled
  {
  echo "<form method='post' action='$_PHP_SELF'>
  Email: <input name='email' type='text' required /><br />
  Subject: <input name='name' type='text' required /><br />
  Message:<br />
  <textarea name='message' required rows='15' cols='40'>
  </textarea><br /><br />
  <input type='submit'value='Send' />
  <button><a href='index.php'>Back to Home Page</a></button>
  </form>";
  }
?>