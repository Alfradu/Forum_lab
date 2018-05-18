<?php
include 'include/bootstrap.php';

if(!isset($_SESSION["mail"])){
    header("Location: index.php");
}

unset($_SESSION["mail"]);
session_destroy();
header("Location: index.php");
?>
