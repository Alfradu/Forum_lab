<?php
include 'include/models/authorizer.php';
include 'include/models/db.php';

session_start();
if(isset($_SESSION["mail"])){
    header("Location: index.php");
}

$assoc['pass'] = $_POST['pass'];
$assoc['mail'] = $_POST['mail'];
if (!verify($assoc)){
    header("Location: register.php");
} else {
    $db = getDb();
    $stmt = prep($db, "SELECT * from user");
    $bool = false;

    while ($rows = $stmt->fetch()){
        if ($_POST['mail'] == $rows['mail']){
            $bool = true;
        }
    }
    if ($bool == true){
        echo '<h1>Email already in use.</h1>';
        header("Refresh: 2, URL=register.php");
    } else {
        //gen salt
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $salt = '';
        for ($i = 0; $i < 14; $i++) {
            $salt .= $characters[rand(0, $charactersLength - 1)];
        }
        $hashed_pass = sha1($_POST['pass'].$salt);

        prep($db, "INSERT INTO user (mail, pass, salt) VALUES (:mail, :hashpass, :salt)", [
            ':mail' => $_POST['mail'],
            ':hashpass' => $hashed_pass,
            ':salt' => $salt
        ]);
        echo '<h1>Registration complete.</h1>';
        header("Refresh: 2, URL=login.php");
    }
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
