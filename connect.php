<?php 

   $dbHost = "localhost";
   $dbUser = "yangshan";
   $dbPass = "shanliang87";
   $dbName = "webshop";

   $connection=
   mysqli_connect($dbHost, $dbUser, $dbPass, $dbName)
   or die("Fel vid connect");

    // Lägg till denna rad för att lösa problem med svenska tecken.
    mysqli_set_charset($connection, "utf8");
?>