<?php
if (trim($_POST['name'], " ") == "" || trim($_POST['mail'], " ") == "" || trim($_POST['text'], " ") == ""){
    header("Location: index.php");
} else {
    $db = new PDO("mysql:host=localhost;dbname=db", 'root', 'root');

    if ($_POST['type'] == "thread"){
        $result = $db->prepare("SELECT MAX(id) AS p_id FROM comments");
        $result->execute();
        $maxId = $result->fetch(PDO::FETCH_ASSOC);
        $tempID = $maxId['p_id'] + 1;
        $location = "thread.php?id=$tempID";
    } else {
        $tempID = $_GET['id'];
        $location = "thread.php?id=$tempID#bottomOfPage";
    }
    //beroende av dbms: setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt = $db->prepare("INSERT INTO comments (name, mail, comm, parent) VALUES (:name, :mail, :comm, :tempId)");
    $stmt->execute(array(
        ':name'    => $_POST['name'],
        ':mail'    => $_POST['mail'],
        ':comm'    => $_POST['text'],
        ':tempId'  => $tempID
    ));
    $db = NULL;
    header("Location: $location");
}
?>
