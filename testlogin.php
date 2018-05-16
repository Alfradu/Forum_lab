<?php
session_start();
if(isset($_SESSION["mail"])){
    header("Location: index.php");
}
$splitMail = explode("@", $_POST['mail']);
if (count($splitMail) == 2){
    $nextSplit = explode(".", $splitMail[1]);
}
$passCheck = true;
if (strlen($_POST['pass']) < 8) {
    $passCheck = false;
}
preg_match('/[0-9]+/', $_POST['pass'], $matches, PREG_UNMATCHED_AS_NULL);
if ($matches == null) {
    $passCheck = false;
}
preg_match('/[a-zA-Z]+/', $_POST['pass'], $matches, PREG_UNMATCHED_AS_NULL);
if ($matches == null) {
    $passCheck = false;
}
if (!(count($nextSplit) == 2) || $passCheck == false){
    header("Location: login.php");
} else {
    $db = new PDO("mysql:host=localhost;dbname=db", 'root', 'root');
    $stmt = $db->prepare("SELECT * from user");
    $db = NULL;
    $stmt->execute();
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
