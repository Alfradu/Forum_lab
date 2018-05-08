<?php
session_start();
if(isset($_SESSION["mail"])){
    header("Location: index.php");
}
if (trim($_POST['mail'], " ") == "" || trim($_POST['pass'], " ") == ""){
    header("Location: register.php");
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
            $bool = true;
        }
    }
    if ($bool == 'true'){
        $db = NULL;
        $bd2 = NULL;
        echo '<h1>Email already in use.</h1>';
        header("Refresh: 2, URL=register.php");
    } else {
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (mail, pass) VALUES ('$mail', '$hashed_pass')";
        $db -> query($query);
        $bd2 = NULL;
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
