<?php
session_start();
if(isset($_SESSION["mail"])){
    header("Location: index.php");
}
if (trim($_POST['mail'], " ") == "" || trim($_POST['pass'], " ") == ""){
    header("Location: register.php");
} else {
    $db = new PDO("mysql:host=localhost;dbname=db", 'root', 'root');
    $table = 'user';
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
        $hashed_pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO user (mail, pass) VALUES (:mail, :hashpass)");
        $stmt->execute([
            ':mail' => $_POST['mail'],
            ':hashpass' => $hashed_pass
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
