<?php
include 'include/models/authorizer.php';
include 'include/models/db.php';

$assoc['name'] = $_POST['name'];
$assoc['mail'] = $_POST['mail'];
$assoc['text'] = $_POST['text'];
if (!verify($assoc)){
    header("Location: index.php");
} else {
    $db = getDb();
    if ($_POST['type'] == "thread"){
        $stmt = prep($db, "SELECT MAX(id) AS p_id FROM comments");
        $maxId = $stmt->fetch(PDO::FETCH_ASSOC);
        $tempID = $maxId['p_id'] + 1;
        $location = "thread.php?id=$tempID";
    } else {
        $tempID = $_GET['id'];
        $location = "thread.php?id=$tempID#bottomOfPage";
    }
    prep($db, "INSERT INTO comments (name, mail, comm, parent) VALUES (:name, :mail, :comm, :tempId)", [
        ':name'    => $_POST['name'],
        ':mail'    => $_POST['mail'],
        ':comm'    => $_POST['text'],
        ':tempId'  => $tempID
    ]);
    $db = NULL;
    header("Location: $location");
}
?>
