<?php
include 'include/bootstrap.php';

$assoc['name'] = $_POST['name'];
$assoc['mail'] = $_POST['mail'];
$assoc['text'] = $_POST['text'];
if (!verify($assoc)){
    header("Location: index.php");
} else {
    if ($_POST['type'] == "thread"){
        createPost();
        $stmt = getMaxId();
        $maxId = $stmt->fetch(PDO::FETCH_ASSOC);
        $tempID = $maxId['p_id'];
        updatePost($tempID);
        $location = "thread.php?id=$tempID";
    } else {
        $tempID = $_GET['id'];
        createPost($tempID);
        $location = "thread.php?id=$tempID#bottomOfPage";
    }
    header("Location: $location");
}
?>
