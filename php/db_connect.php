<?php
$url = 'localhost';
$username = 'root';
$password = '';
$con = mysqli_connect($url, $username, $password, "chip_coffee");
if(!$con){
    die('Could not connect to ChipCoffee DB...');
}
?>