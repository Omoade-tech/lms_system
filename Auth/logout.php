<?php
session_start(); 
// $_SESSION = array();

unset($_SESSION['login']);
session_destroy(); 
header("location: ./views/index.php"); 


?>