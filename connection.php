<?php 
$conn = mysqli_connect('localhost','root','','php_mysql_crud');
if(!$conn){
    var_dump(mysqli_connect_error());
    die;
}
?>