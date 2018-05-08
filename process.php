<?php
if (trim($_POST['name'], " ") == "" || trim($_POST['mail'], " ") == "" || trim($_POST['text'], " ") == ""){
    header("Location: index.php");
} else {
    // Create database connection using PHP Data Object (PDO)
    $db = new mysqli('localhost', root, root, 'db');
    $db2 = new PDO("mysql:host=localhost;dbname=db", root, root);
    $table = 'comments';
    $stmt = $db2->query('SELECT * from '.$table);
    $tempID = 1;
    //$location = "index.php";
    $location = "thread.php?id=$tempID";
    if(!$db)
    {
        echo mysqli_error();
    }
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $mail = mysqli_real_escape_string($db, $_POST['mail']);
    $comm = mysqli_real_escape_string($db, $_POST['text']);

    if ($_POST['type'] == "thread"){
        $result = $db2->prepare("SELECT MAX(id) AS p_id FROM comments");
        $result->execute();
        $maxId = $result->fetch(PDO::FETCH_ASSOC);
        $tempID += $maxId['p_id'];
        $location = "thread.php?id=$tempID";
    } else {
        $tempID = $_GET['id'];
        $location = "thread.php?id=$tempID#bottomOfPage";
    }
    $query = "INSERT INTO comments (name, mail, comm, parent) VALUES ('$name', '$mail', '$comm', '$tempID')";
    $db -> query($query);
    $db = NULL;
    $db2 = NULL;
    header("Location: $location");
}
?>
