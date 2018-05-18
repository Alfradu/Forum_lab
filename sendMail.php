<?php
include 'include/bootstrap.php';

if(isset($_SESSION["mail"])){
    header("Location: index.php");
}

$assoc['mail'] = $_POST['mail'];
if (!verify($assoc)){
    header("Location: login.php");
} else {
    //send user to token page and reset password there instead...
    $stmt = getUsers();
    $bool = false;
    while ($rows = $stmt->fetch()){
        if ( $_POST['mail'] == $rows['mail']){
            $bool = true;
        }
    }
    if($bool){
        updatePass();
        $to = $_POST['mail'];
        $subject = "Password reset from Forum!";
        $body = "Hello! This is your new password: ".genString(14);

        if (mail($_POST['mail'], $subject, $body)) {
            echo("<p>Email successfully sent!</p>");
        } else {
            echo("<p>Email delivery failed…</p>");
        }
    } else {
        echo '<h1>Could not find email.</h1>';
    }
    header("Refresh: 3, URL=login.php");
}
?>
