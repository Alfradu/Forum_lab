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
    header("Location: register.php");
} else {
    $db = new PDO("mysql:host=localhost;dbname=db", 'root', 'root');
    $stmt = $db->prepare("SELECT * from user");
    $stmt->execute();
    $bool = false;

    while ($rows = $stmt->fetch()){
        if ($_POST['mail'] == $rows['mail']){
            $bool = true;
        }
    }
    if ($bool == true){
        $db = NULL;
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
        $stmt = $db->prepare("INSERT INTO user (mail, pass, salt) VALUES (:mail, :hashpass, :salt)");
        $stmt->execute([
            ':mail' => $_POST['mail'],
            ':hashpass' => $hashed_pass,
            ':salt' => $salt
        ]);
        $db = NULL;
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
