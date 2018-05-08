<?php
session_start();
if(isset($_SESSION["mail"])){
    header("Location: index.php");
}
if (trim($_POST['mail'], " ") == ""){
    header("Location: login.php");
} else {
    $db = new mysqli('localhost', root, root, 'db');
    $db2 = new PDO("mysql:host=localhost;dbname=db", root, root);

    if(!$db)
    {
        echo mysqli_error();
    }
    $mail = mysqli_real_escape_string($db, $_POST['mail']);
    //generate new password
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $newPassword = password_hash($randomString, PASSWORD_DEFAULT);

    $query = "UPDATE user SET pass='$newPassword' WHERE mail='$mail'";
    if($db2->query($query)){
        echo '<h1>Updated table.</h1>';
    } else {
        echo '<h1>failed update on table.</h1>';
    }
    //mail:
    $subject = "Password reset from Forum!";
    $body = "Hello! This is your new password:".$randomString;
    if (mail($mail, $subject, $body)) {
    echo("<p>Email successfully sent!</p>");
    } else {
    echo("<p>Email delivery failed…</p>");
    }

    $db2 = NULL;
    $db = NULL;
    echo '<h1>Password reset. Check you'."'".'r email inbox.</h1>';
    header("Refresh: 3, URL=login.php");
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
