<?php
session_start();
if(isset($_SESSION["mail"])){
    header("Location: index.php");
}
if (trim($_POST['mail'], " ") == ""){
    header("Location: login.php");
} else {
    //$db = new mysqli('localhost', root, root, 'db');
    $db = new PDO("mysql:host=localhost;dbname=db", 'root', 'root');

    //generate new password
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $newPassword = password_hash($randomString, PASSWORD_DEFAULT);

    $stmt = $db->prepare("UPDATE user SET pass='$newPassword' WHERE mail= :mail");
    if($stmt->execute([
        ':mail' => $_POST['mail']
    ])){
        $to = $_POST['mail'];
        $subject = "Password reset from Forum!";
        $body = "Hello! This is your new password: ".$randomString;

        if (mail($_POST['mail'], $subject, $body)) {
            echo("<p>Email successfully sent!</p>");
        } else {
            echo("<p>Email delivery failed…</p>");
        }
    } else {
        echo '<h1>Could not find email.</h1>';
    }
    $db = NULL;
    header("Refresh: 100, URL=login.php");
}
?>
<html>
    <head>
        <title>Forum</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    </head>
    <body>
    </body>
</html>
