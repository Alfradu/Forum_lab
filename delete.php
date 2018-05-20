<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include 'include/bootstrap.php';

if(!isset($_SESSION["mail"])){
    header("Location: ".$_POST["currentPage"]);
} else {
    $mail = "";
    $location = "index.php";
    $stmt = getComments();
    $arr = explode(',', $_POST["checkArr"]);
    for ($x = 0; $x <= count($arr)-1; $x++) {
       while($comments = $stmt->fetch()){
           if ($arr[$x] == $comments["id"]){
               $parent = $comments["parent"];
               $mail = $comments["mail"];
           }
       }
        if ($mail == $_SESSION["mail"]){
           if ($parent == $arr[$x]){
               $location = "index.php";
               deleteThread($parent);
           } else {
               $location = "thread.php?id=$parent#bottomOfPage";
               deletePost($arr[$x]);
           }
       }
    }
    header("Location: $location");
}
?>
