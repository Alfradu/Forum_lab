<?php
include 'include/bootstrap.php';
include 'include/views/register.php';
if(isset($_SESSION["mail"])){
    header("Location: index.php");
}
?>
