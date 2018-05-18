<?php
include 'include/bootstrap.php';

$assoc['name'] = $_POST['name'];
$assoc['mail'] = $_POST['mail'];
$assoc['text'] = $_POST['text'];
if (!verify($assoc)){
    header("Location: index.php");
} else {
    if ($_POST['type'] == "thread"){
        $stmt = getMaxId();
        $maxId = $stmt->fetch(PDO::FETCH_ASSOC);
        $tempID = $maxId['p_id'] + 1;
        $location = "thread.php?id=$tempID";
    } else {
        $tempID = $_GET['id'];
        $location = "thread.php?id=$tempID#bottomOfPage";
    }
    createPost($tempID);
    header("Location: $location");
}
?>
