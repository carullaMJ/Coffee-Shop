<?php 
$connect = mysqli_connect('localhost', 'root', '', 'coffeeshop');
if (!$connect) {
    echo 'Connection Error!'.mysqli_connect_error();
}
?>