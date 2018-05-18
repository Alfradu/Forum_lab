<?php
include 'include/bootstrap.php';
include 'include/views/login.php';
if(isset($_SESSION["mail"])){
    header("Location: index.php");
}
?>
