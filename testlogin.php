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
    header("Location: login.php");
} else {
    $db = getDb();
    $stmt = prep($db, "SELECT * from user");
    $bool = false;
    while ($rows = $stmt->fetch()){
        if ( $_POST['mail'] == $rows['mail']){
            $login_hash = $rows['pass'];
            $login_salt = $rows['salt'];
            $bool = true;
        }
    }
    if ($bool == true){
        if (sha1($_POST['pass'].$login_salt) === $login_hash){
            $_SESSION["mail"] = $_POST['mail'];
            echo '<h1>Logged in, redirecting to forum...</h1>';
            header("Refresh: 2, URL=index.php");
        } else {
            echo '<h1>Wrong password.</h1>';
            header("Refresh: 2, URL=login.php");
        }
    } else {
        echo '<h1>Password or mail didn'."'".'t match.</h1>';
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
