<?php
session_start();
if(!isset($_SESSION["mail"])){
    header("Location: index.php");
}
unset($_SESSION["mail"]);
session_destroy();
header("Location: index.php");
?>
