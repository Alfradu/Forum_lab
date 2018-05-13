<?php
session_start();
if(isset($_SESSION["mail"])){
    header("Location: index.php");
}
if (trim($_POST['mail'], " ") == "" || trim($_POST['pass'], " ") == ""){
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
        //requires php ver 7.*
        //probably just use openssl_random_pseudo_bytes() for versions below 7.
        //normally password_hash() would be the "safe" function to use
        $salt = random_bytes(14);
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
