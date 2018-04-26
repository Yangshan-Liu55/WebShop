<?php 

require('connect.php');

$query="SELECT * FROM Product";

$table=mysqli_query($connection, $query) 
or die(mysql_error($connection));
$rows=array();

while($row = mysqli_fetch_assoc($table)) {
    $rows[] = $row;
 }
 echo json_encode($rows);
?>