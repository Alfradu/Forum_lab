<?php
session_start();
if(isset($_SESSION["mail"])){
    header("Location: index.php");
}
if (trim($_POST['mail'], " ") == "" || trim($_POST['pass'], " ") == ""){
    header("Location: login.php");
} else {
    $db2 = new mysqli('localhost', root, root, 'db');
    $db = new PDO("mysql:host=localhost;dbname=db", root, root);
    $table = 'user';
    $stmt = $db->query('SELECT * from '.$table);

    if(!$db)
    {
        echo mysqli_error();
    }

    $mail = mysqli_real_escape_string($db2, $_POST['mail']);
    $pass = mysqli_real_escape_string($db2, $_POST['pass']);
    $bool = 'false';

    while ($rows = $stmt->fetch()){
        if ($mail == $rows['mail']){
            $login_hash = $rows['pass'];
            $bool = true;
        }
    }
    if ($bool == 'true'){
        $db = NULL;
        $bd2 = NULL;

        if (password_verify($pass, $login_hash)){
            session_start();
            $_SESSION["mail"] = $mail;
            echo '<h1>Logged in, redirecting to forum...</h1>';
            header("Refresh: 2, URL=index.php");
        } else {
            echo '<h1>Wrong password.</h1>';
            header("Refresh: 2, URL=login.php");
        }
    } else {
        $bd2 = NULL;
        $db = NULL;
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
